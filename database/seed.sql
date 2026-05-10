USE traveloop;

INSERT INTO users (id, first_name, last_name, email, phone, city, country, password_hash, bio, language)
VALUES
    (1, 'Demo', 'Traveler', 'demo@traveloop.test', '+91 90000 00000', 'Ahmedabad', 'India', '$2y$10$wZQpqzpm1zIvvfF1Jq0CHeaWQUYaGmzcVZ0K8ezxU5Qwx7FY3KcDm', 'Prefers food walks, heritage neighborhoods, and train-friendly plans.', 'English'),
    (2, 'Asha', 'Mehta', 'asha@traveloop.test', '+91 90000 00001', 'Mumbai', 'India', '$2y$10$wZQpqzpm1zIvvfF1Jq0CHeaWQUYaGmzcVZ0K8ezxU5Qwx7FY3KcDm', 'Community route curator.', 'English');

INSERT INTO cities (id, name, country, region, cost_index, popularity, image, summary)
VALUES
    (1, 'Mumbai', 'India', 'West India', 72, 94, 'assets/img/city-mumbai.jpg', 'Street food, colonial walks, sea views, and late-night neighborhoods.'),
    (2, 'Jaipur', 'India', 'Rajasthan', 58, 91, 'assets/img/city-jaipur.jpg', 'Palaces, forts, textile markets, and structured day tours.'),
    (3, 'Udaipur', 'India', 'Rajasthan', 64, 88, 'assets/img/city-udaipur.jpg', 'Lakefront stays, sunset viewpoints, and compact walking routes.'),
    (4, 'Kochi', 'India', 'Kerala', 61, 83, 'assets/img/city-kochi.jpg', 'Ferries, food trails, historic lanes, and harbor evenings.');

INSERT INTO trips (id, user_id, name, description, start_date, end_date, cover_photo, budget_limit, status, visibility, share_code)
VALUES
    (1, 1, 'Western India Explorer', 'A city-to-city plan through food, heritage walks, lake evenings, and local markets.', '2026-05-18', '2026-05-25', 'assets/img/traveloop-cover.jpg', 2200.00, 'ongoing', 'public', 'west-loop'),
    (2, 1, 'Coastal Food Trail', 'A short Kochi getaway planned around ferry rides, cafes, and spice markets.', '2026-06-12', '2026-06-16', 'assets/img/city-kochi.jpg', 1200.00, 'upcoming', 'friends', 'coast-food'),
    (3, 1, 'Royal Weekend', 'Jaipur palaces, stepwells, textiles, and a compact activity calendar.', '2026-04-04', '2026-04-07', 'assets/img/city-jaipur.jpg', 950.00, 'completed', 'public', 'royal-weekend');

INSERT INTO trip_stops (id, trip_id, city_id, start_date, end_date, sort_order, note)
VALUES
    (1, 1, 1, '2026-05-18', '2026-05-20', 1, 'Start with food, sea views, and train-friendly hotel location.'),
    (2, 1, 2, '2026-05-21', '2026-05-23', 2, 'Keep palace visits early and markets late afternoon.'),
    (3, 1, 3, '2026-05-24', '2026-05-25', 3, 'A lighter ending with lake time and notes for onward travel.'),
    (4, 2, 4, '2026-06-12', '2026-06-16', 1, 'Ferry-friendly hotel and food tour schedule.'),
    (5, 3, 2, '2026-04-04', '2026-04-07', 1, 'Short palace and bazaar loop.');

INSERT INTO activities (id, city_id, name, type, duration_hours, cost, summary)
VALUES
    (1, 1, 'Colaba heritage walk', 'Sightseeing', 3.0, 35.00, 'Guided walk through art deco lanes and waterfront landmarks.'),
    (2, 1, 'Local food crawl', 'Food', 4.0, 48.00, 'Small group route covering snacks, sweets, and market stops.'),
    (3, 2, 'Amber Fort morning', 'History', 4.0, 42.00, 'Early palace visit with photo stops and local guide.'),
    (4, 2, 'Textile bazaar route', 'Shopping', 2.0, 22.00, 'Fabric, craft, and block-print shopping route.'),
    (5, 3, 'Lake Pichola sunset boat', 'Relaxed', 2.0, 28.00, 'Evening route across the lake with skyline views.'),
    (6, 4, 'Spice market and ferry loop', 'Culture', 5.0, 39.00, 'Market tastings, ferry hops, and neighborhood exploration.');

INSERT INTO stop_activities (stop_id, activity_id, scheduled_time)
VALUES
    (1, 1, '09:30:00'),
    (1, 2, '18:00:00'),
    (2, 3, '08:00:00'),
    (2, 4, '16:30:00'),
    (3, 5, '17:45:00'),
    (4, 6, '10:00:00');

INSERT INTO budget_items (trip_id, category, description, vendor, estimated_cost, actual_cost)
VALUES
    (1, 'Stay', 'Mumbai boutique hotel', 'Harbor Inn', 240.00, 250.00),
    (1, 'Stay', 'Jaipur guesthouse', 'Pink City Rooms', 300.00, 292.00),
    (1, 'Stay', 'Udaipur lake stay', 'Lake View House', 180.00, 180.00),
    (1, 'Transport', 'Intercity train tickets', 'Railway', 180.00, 176.00),
    (1, 'Transport', 'Local rides', 'Mixed', 280.00, 268.00),
    (1, 'Activities', 'Guided city walks', 'Local Guides', 145.00, 150.00),
    (1, 'Activities', 'Boat and fort tickets', 'Mixed', 195.00, 188.00),
    (1, 'Meals', 'Food crawl and daily meals', 'Mixed', 320.00, 305.00),
    (2, 'Stay', 'Kochi homestay', 'Harbor House', 360.00, NULL),
    (2, 'Meals', 'Food tour and cafes', 'Mixed', 220.00, NULL);

INSERT INTO packing_items (trip_id, item, category, packed)
VALUES
    (1, 'Passport or national ID', 'Documents', 1),
    (1, 'Hotel confirmations', 'Documents', 1),
    (1, 'Light cotton shirts', 'Clothing', 0),
    (1, 'Power bank', 'Electronics', 0),
    (1, 'Basic medicines', 'Health', 0);

INSERT INTO trip_notes (trip_id, stop_id, title, body, note_date)
VALUES
    (1, 1, 'Mumbai check-in', 'Ask hotel desk about early luggage storage and local train card.', '2026-05-18'),
    (1, 2, 'Jaipur contact', 'Guide pickup is outside the main gate at 7:45 AM.', '2026-05-21'),
    (1, 3, 'Udaipur reminder', 'Reserve lake boat tickets one day before arrival.', '2026-05-24');

INSERT INTO community_posts (user_id, trip_id, title, body, likes)
VALUES
    (2, 1, 'Seven days without rushing', 'This route keeps the first two days active and the final lake stop slower.', 42),
    (1, 2, 'Best ferry timing', 'Late afternoon ferry hops made the Kochi route feel cooler and easier.', 27),
    (2, 3, 'Compact Jaipur loop', 'Amber Fort early, City Palace midday, textile markets after tea worked well.', 33);
