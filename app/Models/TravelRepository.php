<?php

declare(strict_types=1);

final class TravelRepository
{
    public function databaseAvailable(): bool
    {
        return Database::connection() instanceof PDO;
    }

    public function user(): array
    {
        return $_SESSION['user'] ?? [
            'id' => 1,
            'name' => 'Demo Traveler',
            'email' => 'demo@traveloop.test',
            'city' => 'Ahmedabad',
            'country' => 'India',
            'language' => 'English',
        ];
    }

    public function createUser(array $data): void
    {
        $this->fromDb(function (PDO $pdo) use ($data): void {
            $stmt = $pdo->prepare(
                'INSERT INTO users (first_name, last_name, email, phone, city, country, password_hash, bio)
                 VALUES (:first_name, :last_name, :email, :phone, :city, :country, :password_hash, :bio)'
            );
            $stmt->execute([
                'first_name' => $data['first_name'] ?? '',
                'last_name' => $data['last_name'] ?? '',
                'email' => $data['email'] ?? '',
                'phone' => $data['phone'] ?? '',
                'city' => $data['city'] ?? '',
                'country' => $data['country'] ?? '',
                'password_hash' => password_hash($data['password'] ?? 'traveloop', PASSWORD_DEFAULT),
                'bio' => $data['bio'] ?? '',
            ]);
        }, null);
    }

    public function trips(): array
    {
        return $this->fromDb(function (PDO $pdo): array {
            $stmt = $pdo->query(
                'SELECT t.*,
                    COALESCE(stop_counts.city_count, 0) AS city_count,
                    COALESCE(budget_totals.spent, 0) AS spent
                 FROM trips t
                 LEFT JOIN (
                    SELECT trip_id, COUNT(*) AS city_count
                    FROM trip_stops
                    GROUP BY trip_id
                 ) stop_counts ON stop_counts.trip_id = t.id
                 LEFT JOIN (
                    SELECT trip_id, SUM(estimated_cost) AS spent
                    FROM budget_items
                    GROUP BY trip_id
                 ) budget_totals ON budget_totals.trip_id = t.id
                 ORDER BY t.start_date ASC'
            );

            return $stmt->fetchAll();
        }, $this->sampleTrips());
    }

    public function trip(int|string $id): array
    {
        $fallback = $this->sampleTrip((int) $id);

        return $this->fromDb(function (PDO $pdo) use ($id, $fallback): array {
            $stmt = $pdo->prepare(
                'SELECT t.*,
                    COALESCE(stop_counts.city_count, 0) AS city_count,
                    COALESCE(budget_totals.spent, 0) AS spent
                 FROM trips t
                 LEFT JOIN (
                    SELECT trip_id, COUNT(*) AS city_count
                    FROM trip_stops
                    GROUP BY trip_id
                 ) stop_counts ON stop_counts.trip_id = t.id
                 LEFT JOIN (
                    SELECT trip_id, SUM(estimated_cost) AS spent
                    FROM budget_items
                    GROUP BY trip_id
                 ) budget_totals ON budget_totals.trip_id = t.id
                 WHERE t.id = :id
                 LIMIT 1'
            );
            $stmt->execute(['id' => $id]);

            return $stmt->fetch() ?: $fallback;
        }, $fallback);
    }

    public function createTrip(array $data): int
    {
        return $this->fromDb(function (PDO $pdo) use ($data): int {
            $stmt = $pdo->prepare(
                'INSERT INTO trips (user_id, name, description, start_date, end_date, cover_photo, budget_limit, status, share_code)
                 VALUES (1, :name, :description, :start_date, :end_date, :cover_photo, :budget_limit, :status, :share_code)'
            );
            $stmt->execute([
                'name' => $data['name'] ?? 'Untitled trip',
                'description' => $data['description'] ?? '',
                'start_date' => $data['start_date'] ?: null,
                'end_date' => $data['end_date'] ?: null,
                'cover_photo' => 'assets/img/traveloop-cover.jpg',
                'budget_limit' => (float) ($data['budget_limit'] ?? 1800),
                'status' => 'upcoming',
                'share_code' => substr(bin2hex(random_bytes(5)), 0, 10),
            ]);

            return (int) $pdo->lastInsertId();
        }, 1);
    }

    public function cities(): array
    {
        return $this->fromDb(function (PDO $pdo): array {
            return $pdo->query('SELECT * FROM cities ORDER BY popularity DESC, name ASC')->fetchAll();
        }, $this->sampleCities());
    }

    public function activities(): array
    {
        return $this->fromDb(function (PDO $pdo): array {
            $stmt = $pdo->query(
                'SELECT a.*, c.name AS city_name
                 FROM activities a
                 LEFT JOIN cities c ON c.id = a.city_id
                 ORDER BY a.type ASC, a.name ASC'
            );

            return $stmt->fetchAll();
        }, $this->sampleActivities());
    }

    public function stops(int|string $tripId): array
    {
        return $this->fromDb(function (PDO $pdo) use ($tripId): array {
            $stmt = $pdo->prepare(
                'SELECT s.*, c.name AS city_name, c.country, c.image
                 FROM trip_stops s
                 JOIN cities c ON c.id = s.city_id
                 WHERE s.trip_id = :trip_id
                 ORDER BY s.sort_order ASC, s.start_date ASC'
            );
            $stmt->execute(['trip_id' => $tripId]);
            $stops = $stmt->fetchAll();

            foreach ($stops as &$stop) {
                $activityStmt = $pdo->prepare(
                    'SELECT a.*, sa.scheduled_time
                     FROM stop_activities sa
                     JOIN activities a ON a.id = sa.activity_id
                     WHERE sa.stop_id = :stop_id
                     ORDER BY sa.scheduled_time ASC'
                );
                $activityStmt->execute(['stop_id' => $stop['id']]);
                $stop['activities'] = $activityStmt->fetchAll();
            }

            return $stops;
        }, $this->sampleStops());
    }

    public function budget(int|string $tripId): array
    {
        $fallback = $this->sampleBudget();

        return $this->fromDb(function (PDO $pdo) use ($tripId, $fallback): array {
            $stmt = $pdo->prepare(
                'SELECT category, SUM(estimated_cost) AS total
                 FROM budget_items
                 WHERE trip_id = :trip_id
                 GROUP BY category
                 ORDER BY total DESC'
            );
            $stmt->execute(['trip_id' => $tripId]);
            $rows = $stmt->fetchAll();

            if (!$rows) {
                return $fallback;
            }

            $total = array_sum(array_map(fn (array $row): float => (float) $row['total'], $rows));

            return [
                'total' => $total,
                'average_day' => $total / 7,
                'limit' => 2200,
                'items' => $rows,
            ];
        }, $fallback);
    }

    public function checklist(int|string $tripId): array
    {
        return $this->fromDb(function (PDO $pdo) use ($tripId): array {
            $stmt = $pdo->prepare(
                'SELECT * FROM packing_items
                 WHERE trip_id = :trip_id
                 ORDER BY category ASC, packed ASC, item ASC'
            );
            $stmt->execute(['trip_id' => $tripId]);

            return $stmt->fetchAll();
        }, $this->sampleChecklist());
    }

    public function addChecklistItem(int|string $tripId, array $data): void
    {
        $this->fromDb(function (PDO $pdo) use ($tripId, $data): void {
            $stmt = $pdo->prepare(
                'INSERT INTO packing_items (trip_id, item, category, packed)
                 VALUES (:trip_id, :item, :category, 0)'
            );
            $stmt->execute([
                'trip_id' => $tripId,
                'item' => $data['item'] ?? '',
                'category' => $data['category'] ?? 'General',
            ]);
        }, null);
    }

    public function notes(int|string $tripId): array
    {
        return $this->fromDb(function (PDO $pdo) use ($tripId): array {
            $stmt = $pdo->prepare(
                'SELECT * FROM trip_notes
                 WHERE trip_id = :trip_id
                 ORDER BY note_date DESC, created_at DESC'
            );
            $stmt->execute(['trip_id' => $tripId]);

            return $stmt->fetchAll();
        }, $this->sampleNotes());
    }

    public function addNote(int|string $tripId, array $data): void
    {
        $this->fromDb(function (PDO $pdo) use ($tripId, $data): void {
            $stmt = $pdo->prepare(
                'INSERT INTO trip_notes (trip_id, stop_id, title, body, note_date)
                 VALUES (:trip_id, NULL, :title, :body, :note_date)'
            );
            $stmt->execute([
                'trip_id' => $tripId,
                'title' => $data['title'] ?? 'Trip note',
                'body' => $data['body'] ?? '',
                'note_date' => $data['note_date'] ?: date('Y-m-d'),
            ]);
        }, null);
    }

    public function communityPosts(): array
    {
        return $this->fromDb(function (PDO $pdo): array {
            $stmt = $pdo->query(
                'SELECT cp.*, t.name AS trip_name, CONCAT(u.first_name, " ", u.last_name) AS author
                 FROM community_posts cp
                 JOIN trips t ON t.id = cp.trip_id
                 JOIN users u ON u.id = cp.user_id
                 ORDER BY cp.created_at DESC'
            );

            return $stmt->fetchAll();
        }, $this->sampleCommunityPosts());
    }

    public function adminStats(): array
    {
        return $this->fromDb(function (PDO $pdo): array {
            $counts = [
                'users' => (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn(),
                'trips' => (int) $pdo->query('SELECT COUNT(*) FROM trips')->fetchColumn(),
                'cities' => (int) $pdo->query('SELECT COUNT(*) FROM cities')->fetchColumn(),
                'activities' => (int) $pdo->query('SELECT COUNT(*) FROM activities')->fetchColumn(),
            ];
            $topCities = $pdo->query(
                'SELECT c.name, COUNT(*) AS trips
                 FROM trip_stops s
                 JOIN cities c ON c.id = s.city_id
                 GROUP BY c.name
                 ORDER BY trips DESC
                 LIMIT 5'
            )->fetchAll();

            return ['counts' => $counts, 'top_cities' => $topCities];
        }, [
            'counts' => ['users' => 128, 'trips' => 342, 'cities' => 24, 'activities' => 96],
            'top_cities' => [
                ['name' => 'Jaipur', 'trips' => 84],
                ['name' => 'Mumbai', 'trips' => 71],
                ['name' => 'Udaipur', 'trips' => 53],
                ['name' => 'Kochi', 'trips' => 39],
            ],
        ]);
    }

    public function expenses(int|string $tripId): array
    {
        return $this->fromDb(function (PDO $pdo) use ($tripId): array {
            $stmt = $pdo->prepare(
                'SELECT *
                 FROM budget_items
                 WHERE trip_id = :trip_id
                 ORDER BY category ASC, description ASC'
            );
            $stmt->execute(['trip_id' => $tripId]);
            $rows = $stmt->fetchAll();

            return $rows ?: $this->sampleExpenses();
        }, $this->sampleExpenses());
    }

    private function fromDb(callable $callback, mixed $fallback): mixed
    {
        $pdo = Database::connection();
        if (!$pdo instanceof PDO) {
            return $fallback;
        }

        try {
            return $callback($pdo);
        } catch (Throwable) {
            return $fallback;
        }
    }

    private function sampleTrip(int $id): array
    {
        foreach ($this->sampleTrips() as $trip) {
            if ((int) $trip['id'] === $id) {
                return $trip;
            }
        }

        return $this->sampleTrips()[0];
    }

    private function sampleTrips(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Western India Explorer',
                'description' => 'A city-to-city plan through food, heritage walks, lake evenings, and local markets.',
                'start_date' => '2026-05-18',
                'end_date' => '2026-05-25',
                'cover_photo' => 'assets/img/traveloop-cover.jpg',
                'budget_limit' => 2200,
                'status' => 'ongoing',
                'share_code' => 'west-loop',
                'city_count' => 3,
                'spent' => 1840,
            ],
            [
                'id' => 2,
                'name' => 'Coastal Food Trail',
                'description' => 'A short Kochi getaway planned around ferry rides, cafes, and spice markets.',
                'start_date' => '2026-06-12',
                'end_date' => '2026-06-16',
                'cover_photo' => 'assets/img/city-kochi.jpg',
                'budget_limit' => 1200,
                'status' => 'upcoming',
                'share_code' => 'coast-food',
                'city_count' => 1,
                'spent' => 790,
            ],
            [
                'id' => 3,
                'name' => 'Royal Weekend',
                'description' => 'Jaipur palaces, stepwells, textiles, and a compact activity calendar.',
                'start_date' => '2026-04-04',
                'end_date' => '2026-04-07',
                'cover_photo' => 'assets/img/city-jaipur.jpg',
                'budget_limit' => 950,
                'status' => 'completed',
                'share_code' => 'royal-weekend',
                'city_count' => 1,
                'spent' => 880,
            ],
        ];
    }

    private function sampleCities(): array
    {
        return [
            ['id' => 1, 'name' => 'Mumbai', 'country' => 'India', 'region' => 'West India', 'cost_index' => 72, 'popularity' => 94, 'image' => 'assets/img/city-mumbai.jpg', 'summary' => 'Street food, colonial walks, sea views, and late-night neighborhoods.'],
            ['id' => 2, 'name' => 'Jaipur', 'country' => 'India', 'region' => 'Rajasthan', 'cost_index' => 58, 'popularity' => 91, 'image' => 'assets/img/city-jaipur.jpg', 'summary' => 'Palaces, forts, textile markets, and structured day tours.'],
            ['id' => 3, 'name' => 'Udaipur', 'country' => 'India', 'region' => 'Rajasthan', 'cost_index' => 64, 'popularity' => 88, 'image' => 'assets/img/city-udaipur.jpg', 'summary' => 'Lakefront stays, sunset viewpoints, and compact walking routes.'],
            ['id' => 4, 'name' => 'Kochi', 'country' => 'India', 'region' => 'Kerala', 'cost_index' => 61, 'popularity' => 83, 'image' => 'assets/img/city-kochi.jpg', 'summary' => 'Ferries, food trails, historic lanes, and harbor evenings.'],
        ];
    }

    private function sampleActivities(): array
    {
        return [
            ['id' => 1, 'city_id' => 1, 'city_name' => 'Mumbai', 'name' => 'Colaba heritage walk', 'type' => 'Sightseeing', 'duration_hours' => 3, 'cost' => 35, 'summary' => 'Guided walk through art deco lanes and waterfront landmarks.'],
            ['id' => 2, 'city_id' => 1, 'city_name' => 'Mumbai', 'name' => 'Local food crawl', 'type' => 'Food', 'duration_hours' => 4, 'cost' => 48, 'summary' => 'Small group route covering snacks, sweets, and market stops.'],
            ['id' => 3, 'city_id' => 2, 'city_name' => 'Jaipur', 'name' => 'Amber Fort morning', 'type' => 'History', 'duration_hours' => 4, 'cost' => 42, 'summary' => 'Early palace visit with photo stops and local guide.'],
            ['id' => 4, 'city_id' => 3, 'city_name' => 'Udaipur', 'name' => 'Lake Pichola sunset boat', 'type' => 'Relaxed', 'duration_hours' => 2, 'cost' => 28, 'summary' => 'Evening route across the lake with skyline views.'],
            ['id' => 5, 'city_id' => 4, 'city_name' => 'Kochi', 'name' => 'Spice market and ferry loop', 'type' => 'Culture', 'duration_hours' => 5, 'cost' => 39, 'summary' => 'Market tastings, ferry hops, and neighborhood exploration.'],
        ];
    }

    private function sampleStops(): array
    {
        return [
            [
                'id' => 1,
                'trip_id' => 1,
                'city_id' => 1,
                'city_name' => 'Mumbai',
                'country' => 'India',
                'image' => 'assets/img/city-mumbai.jpg',
                'start_date' => '2026-05-18',
                'end_date' => '2026-05-20',
                'sort_order' => 1,
                'note' => 'Start with food, sea views, and train-friendly hotel location.',
                'activities' => [
                    ['name' => 'Colaba heritage walk', 'type' => 'Sightseeing', 'scheduled_time' => '09:30:00', 'duration_hours' => 3, 'cost' => 35],
                    ['name' => 'Local food crawl', 'type' => 'Food', 'scheduled_time' => '18:00:00', 'duration_hours' => 4, 'cost' => 48],
                ],
            ],
            [
                'id' => 2,
                'trip_id' => 1,
                'city_id' => 2,
                'city_name' => 'Jaipur',
                'country' => 'India',
                'image' => 'assets/img/city-jaipur.jpg',
                'start_date' => '2026-05-21',
                'end_date' => '2026-05-23',
                'sort_order' => 2,
                'note' => 'Keep palace visits early and markets late afternoon.',
                'activities' => [
                    ['name' => 'Amber Fort morning', 'type' => 'History', 'scheduled_time' => '08:00:00', 'duration_hours' => 4, 'cost' => 42],
                    ['name' => 'Textile bazaar route', 'type' => 'Shopping', 'scheduled_time' => '16:30:00', 'duration_hours' => 2, 'cost' => 22],
                ],
            ],
            [
                'id' => 3,
                'trip_id' => 1,
                'city_id' => 3,
                'city_name' => 'Udaipur',
                'country' => 'India',
                'image' => 'assets/img/city-udaipur.jpg',
                'start_date' => '2026-05-24',
                'end_date' => '2026-05-25',
                'sort_order' => 3,
                'note' => 'A lighter ending with lake time and notes for onward travel.',
                'activities' => [
                    ['name' => 'Lake Pichola sunset boat', 'type' => 'Relaxed', 'scheduled_time' => '17:45:00', 'duration_hours' => 2, 'cost' => 28],
                ],
            ],
        ];
    }

    private function sampleBudget(): array
    {
        return [
            'total' => 1840,
            'average_day' => 263,
            'limit' => 2200,
            'items' => [
                ['category' => 'Stay', 'total' => 720],
                ['category' => 'Transport', 'total' => 460],
                ['category' => 'Activities', 'total' => 340],
                ['category' => 'Meals', 'total' => 320],
            ],
        ];
    }

    private function sampleChecklist(): array
    {
        return [
            ['id' => 1, 'trip_id' => 1, 'item' => 'Passport or national ID', 'category' => 'Documents', 'packed' => 1],
            ['id' => 2, 'trip_id' => 1, 'item' => 'Hotel confirmations', 'category' => 'Documents', 'packed' => 1],
            ['id' => 3, 'trip_id' => 1, 'item' => 'Light cotton shirts', 'category' => 'Clothing', 'packed' => 0],
            ['id' => 4, 'trip_id' => 1, 'item' => 'Power bank', 'category' => 'Electronics', 'packed' => 0],
            ['id' => 5, 'trip_id' => 1, 'item' => 'Basic medicines', 'category' => 'Health', 'packed' => 0],
        ];
    }

    private function sampleNotes(): array
    {
        return [
            ['id' => 1, 'trip_id' => 1, 'title' => 'Mumbai check-in', 'body' => 'Ask hotel desk about early luggage storage and local train card.', 'note_date' => '2026-05-18', 'created_at' => '2026-05-01 10:20:00'],
            ['id' => 2, 'trip_id' => 1, 'title' => 'Jaipur contact', 'body' => 'Guide pickup is outside the main gate at 7:45 AM.', 'note_date' => '2026-05-21', 'created_at' => '2026-05-02 09:00:00'],
            ['id' => 3, 'trip_id' => 1, 'title' => 'Udaipur reminder', 'body' => 'Reserve lake boat tickets one day before arrival.', 'note_date' => '2026-05-24', 'created_at' => '2026-05-03 18:45:00'],
        ];
    }

    private function sampleCommunityPosts(): array
    {
        return [
            ['id' => 1, 'trip_name' => 'Western India Explorer', 'author' => 'Asha Mehta', 'title' => 'Seven days without rushing', 'body' => 'This route keeps the first two days active and the final lake stop slower.', 'likes' => 42, 'created_at' => '2026-05-05 12:00:00'],
            ['id' => 2, 'trip_name' => 'Coastal Food Trail', 'author' => 'Rohan Shah', 'title' => 'Best ferry timing', 'body' => 'Late afternoon ferry hops made the Kochi route feel cooler and easier.', 'likes' => 27, 'created_at' => '2026-05-04 17:30:00'],
            ['id' => 3, 'trip_name' => 'Royal Weekend', 'author' => 'Nidhi Rao', 'title' => 'Compact Jaipur loop', 'body' => 'Amber Fort early, City Palace midday, textile markets after tea worked well.', 'likes' => 33, 'created_at' => '2026-05-02 08:15:00'],
        ];
    }

    private function sampleExpenses(): array
    {
        return [
            ['category' => 'Stay', 'description' => 'Mumbai boutique hotel', 'vendor' => 'Harbor Inn', 'estimated_cost' => 240, 'actual_cost' => 250],
            ['category' => 'Stay', 'description' => 'Jaipur guesthouse', 'vendor' => 'Pink City Rooms', 'estimated_cost' => 300, 'actual_cost' => 292],
            ['category' => 'Transport', 'description' => 'Intercity train tickets', 'vendor' => 'Railway', 'estimated_cost' => 180, 'actual_cost' => 176],
            ['category' => 'Activities', 'description' => 'Guided city walks', 'vendor' => 'Local Guides', 'estimated_cost' => 145, 'actual_cost' => 150],
            ['category' => 'Meals', 'description' => 'Food crawl and daily meals', 'vendor' => 'Mixed', 'estimated_cost' => 320, 'actual_cost' => 305],
        ];
    }
}
