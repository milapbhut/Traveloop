<?php

declare(strict_types=1);

final class PageController
{
    public function __construct(private TravelRepository $repo)
    {
    }

    public function dashboard(): void
    {
        View::page('pages/dashboard', $this->data([
            'title' => 'Traveloop Dashboard',
            'page' => 'dashboard',
            'trips' => $this->repo->trips(),
            'cities' => $this->repo->cities(),
        ]));
    }

    public function login(): void
    {
        View::page('pages/login', $this->data([
            'title' => 'Login',
            'page' => 'login',
            'minimal' => true,
        ]));
    }

    public function handleLogin(): void
    {
        $email = trim($_POST['email'] ?? '');
        if ($email === '') {
            flash('error', 'Please enter your email address.');
            redirect_to('/login');
        }

        $_SESSION['user'] = [
            'id' => 1,
            'name' => 'Demo Traveler',
            'email' => $email,
            'city' => 'Ahmedabad',
            'country' => 'India',
            'language' => 'English',
        ];
        flash('success', 'Welcome back to Traveloop.');
        redirect_to('/dashboard');
    }

    public function register(): void
    {
        View::page('pages/register', $this->data([
            'title' => 'Create Account',
            'page' => 'register',
            'minimal' => true,
        ]));
    }

    public function handleRegister(): void
    {
        $email = trim($_POST['email'] ?? '');
        if ($email === '') {
            flash('error', 'Email address is required.');
            redirect_to('/register');
        }

        $this->repo->createUser($_POST);
        $_SESSION['user'] = [
            'id' => 1,
            'name' => trim(($_POST['first_name'] ?? 'New') . ' ' . ($_POST['last_name'] ?? 'Traveler')),
            'email' => $email,
            'city' => $_POST['city'] ?? '',
            'country' => $_POST['country'] ?? '',
            'language' => 'English',
        ];
        flash('success', 'Account created. You can start planning now.');
        redirect_to('/dashboard');
    }

    public function forgot(): void
    {
        View::page('pages/forgot', $this->data([
            'title' => 'Forgot Password',
            'page' => 'forgot',
            'minimal' => true,
        ]));
    }

    public function trips(): void
    {
        View::page('pages/trips', $this->data([
            'title' => 'My Trips',
            'page' => 'trips',
            'trips' => $this->repo->trips(),
        ]));
    }

    public function createTrip(): void
    {
        View::page('pages/trip-form', $this->data([
            'title' => 'Create Trip',
            'page' => 'create',
            'cities' => $this->repo->cities(),
            'activities' => $this->repo->activities(),
        ]));
    }

    public function storeTrip(): void
    {
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            flash('error', 'Trip name is required.');
            redirect_to('/trips/create');
        }

        $id = $this->repo->createTrip($_POST);
        flash('success', 'Trip saved. Build the itinerary sections next.');
        redirect_to('/trips/' . $id . '/builder');
    }

    public function builder(string $id): void
    {
        View::page('pages/builder', $this->data([
            'title' => 'Itinerary Builder',
            'page' => 'builder',
            'trip' => $this->repo->trip($id),
            'stops' => $this->repo->stops($id),
            'cities' => $this->repo->cities(),
            'activities' => $this->repo->activities(),
        ]));
    }

    public function itinerary(string $id): void
    {
        View::page('pages/itinerary', $this->data([
            'title' => 'Itinerary View',
            'page' => 'itinerary',
            'trip' => $this->repo->trip($id),
            'stops' => $this->repo->stops($id),
            'budget' => $this->repo->budget($id),
        ]));
    }

    public function citySearch(): void
    {
        View::page('pages/search', $this->data([
            'title' => 'City Search',
            'page' => 'search',
            'mode' => 'cities',
            'cities' => $this->repo->cities(),
            'activities' => $this->repo->activities(),
        ]));
    }

    public function activitySearch(): void
    {
        View::page('pages/search', $this->data([
            'title' => 'Activity Search',
            'page' => 'search',
            'mode' => 'activities',
            'cities' => $this->repo->cities(),
            'activities' => $this->repo->activities(),
        ]));
    }

    public function budget(string $id): void
    {
        View::page('pages/budget', $this->data([
            'title' => 'Budget Breakdown',
            'page' => 'budget',
            'trip' => $this->repo->trip($id),
            'budget' => $this->repo->budget($id),
        ]));
    }

    public function checklist(string $id): void
    {
        View::page('pages/checklist', $this->data([
            'title' => 'Packing Checklist',
            'page' => 'checklist',
            'trip' => $this->repo->trip($id),
            'items' => $this->repo->checklist($id),
        ]));
    }

    public function storeChecklist(string $id): void
    {
        if (trim($_POST['item'] ?? '') !== '') {
            $this->repo->addChecklistItem($id, $_POST);
            flash('success', 'Checklist item added.');
        }

        redirect_to('/trips/' . $id . '/checklist');
    }

    public function share(string $code): void
    {
        $trip = $this->repo->trips()[0];
        foreach ($this->repo->trips() as $candidate) {
            if (($candidate['share_code'] ?? '') === $code) {
                $trip = $candidate;
            }
        }

        View::page('pages/share', $this->data([
            'title' => 'Shared Itinerary',
            'page' => 'share',
            'trip' => $trip,
            'stops' => $this->repo->stops($trip['id']),
        ]));
    }

    public function profile(): void
    {
        View::page('pages/profile', $this->data([
            'title' => 'Profile Settings',
            'page' => 'profile',
            'trips' => $this->repo->trips(),
            'cities' => $this->repo->cities(),
        ]));
    }

    public function notes(string $id): void
    {
        View::page('pages/notes', $this->data([
            'title' => 'Trip Notes',
            'page' => 'notes',
            'trip' => $this->repo->trip($id),
            'notes' => $this->repo->notes($id),
        ]));
    }

    public function storeNote(string $id): void
    {
        if (trim($_POST['body'] ?? '') !== '') {
            $this->repo->addNote($id, $_POST);
            flash('success', 'Note saved.');
        }

        redirect_to('/trips/' . $id . '/notes');
    }

    public function community(): void
    {
        View::page('pages/community', $this->data([
            'title' => 'Community',
            'page' => 'community',
            'posts' => $this->repo->communityPosts(),
        ]));
    }

    public function invoice(string $id): void
    {
        View::page('pages/invoice', $this->data([
            'title' => 'Expense Invoice',
            'page' => 'invoice',
            'trip' => $this->repo->trip($id),
            'expenses' => $this->repo->expenses($id),
        ]));
    }

    public function admin(): void
    {
        View::page('pages/admin', $this->data([
            'title' => 'Admin Analytics',
            'page' => 'admin',
            'stats' => $this->repo->adminStats(),
            'trips' => $this->repo->trips(),
        ]));
    }

    private function data(array $data): array
    {
        return array_merge([
            'user' => $this->repo->user(),
            'dbConnected' => $this->repo->databaseAvailable(),
        ], $data);
    }
}
