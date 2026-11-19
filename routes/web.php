<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ElectionController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LeaderController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MphakatiController;
use App\Http\Controllers\Admin\PrayerIntentionController as AdminPrayerIntentionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController as PublicContactController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PrayerIntentionController;
use App\Http\Controllers\Public\ActivityController as PublicActivityController;
use App\Http\Controllers\Public\ElectionController as PublicElectionController;
use App\Http\Controllers\Public\EventController as PublicEventController;
use App\Http\Controllers\Public\MemberSearchController;
use App\Http\Controllers\Public\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/leadership', [PageController::class, 'leadership'])->name('leadership');

Route::get('/activities', [PublicActivityController::class, 'index'])->name('activities');
Route::get('/activities/{activity}', [PublicActivityController::class, 'show'])->name('activities.show');

Route::get('/news-events', [NewsController::class, 'index'])->name('news');
Route::get('/news/{announcement}', [NewsController::class, 'show'])->name('news.show');

Route::get('/events', [PublicEventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [PublicEventController::class, 'show'])->name('events.show');
Route::post('/events/{event}/register', [PublicEventController::class, 'register'])->middleware('auth')->name('events.register');
Route::post('/events/{event}/vote', [PublicEventController::class, 'vote'])->middleware(['auth', 'member.approved'])->name('events.vote');

Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/daily-readings', [PageController::class, 'dailyReadings'])->name('daily-readings');

Route::get('/members/search', MemberSearchController::class)->name('members.search');

Route::get('/documents/reports/{report}', [DocumentController::class, 'report'])->whereNumber('report')->name('documents.report');
Route::get('/documents/projects', [DocumentController::class, 'projects'])->name('documents.projects');
Route::get('/documents/mphakati', [DocumentController::class, 'allMphakati'])->name('documents.mphakati.all');
Route::get('/documents/mphakati/{group}', [DocumentController::class, 'mphakati'])->where('group', '[^/]+')->name('documents.mphakati');

Route::get('/prayer-intentions', [PrayerIntentionController::class, 'create'])->name('prayer-intentions.create');
Route::post('/prayer-intentions', [PrayerIntentionController::class, 'store'])->middleware('throttle:10,1')->name('prayer-intentions.store');

Route::get('/contact', [PublicContactController::class, 'show'])->name('contact');

Route::get('/join', [MembershipController::class, 'create'])->name('join');
Route::post('/join', [MembershipController::class, 'store'])->name('join.submit');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/account', [AccountController::class, 'dashboard'])->middleware('auth')->name('account.dashboard');
Route::get('/membership/status', [MembershipController::class, 'status'])->middleware('auth')->name('membership.status');
Route::post('/membership/resubmit', [MembershipController::class, 'resubmit'])->middleware('auth')->name('membership.resubmit');

Route::get('/elections', [PublicElectionController::class, 'index'])->name('elections');
Route::get('/elections/{election}', [PublicElectionController::class, 'show'])->whereNumber('election')->name('elections.show');
Route::post('/elections/{election}/vote/{position}', [PublicElectionController::class, 'vote'])
    ->middleware(['auth', 'member.approved'])
    ->whereNumber('election')->whereNumber('position')
    ->name('elections.vote');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/choir', [ActivityController::class, 'choir'])->name('choir.index');
    Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events/{event}/registrations', [EventController::class, 'registrations'])->name('events.registrations');
    Route::post('/events/{event}/registrations/{registration}/attended', [EventController::class, 'toggleAttended'])
        ->whereNumber('registration')->name('events.registrations.attended');

    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::post('/gallery/bulk', [GalleryController::class, 'bulkStore'])->name('gallery.bulk');
    Route::get('/gallery/{photo}/edit', [GalleryController::class, 'edit'])->whereNumber('photo')->name('gallery.edit');
    Route::put('/gallery/{photo}', [GalleryController::class, 'update'])->whereNumber('photo')->name('gallery.update');
    Route::delete('/gallery/{photo}', [GalleryController::class, 'destroy'])->whereNumber('photo')->name('gallery.destroy');

    Route::get('/leaders', [LeaderController::class, 'index'])->name('leaders.index');
    Route::get('/leaders/create', [LeaderController::class, 'create'])->name('leaders.create');
    Route::post('/leaders', [LeaderController::class, 'store'])->name('leaders.store');
    Route::post('/leaders/publish-election/{election}', [LeaderController::class, 'publishElection'])->whereNumber('election')->name('leaders.publish-election');
    Route::get('/leaders/{leader}/edit', [LeaderController::class, 'edit'])->whereNumber('leader')->name('leaders.edit');
    Route::put('/leaders/{leader}', [LeaderController::class, 'update'])->whereNumber('leader')->name('leaders.update');
    Route::delete('/leaders/{leader}', [LeaderController::class, 'destroy'])->whereNumber('leader')->name('leaders.destroy');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->whereNumber('report')->name('reports.edit');
    Route::put('/reports/{report}', [ReportController::class, 'update'])->whereNumber('report')->name('reports.update');
    Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->whereNumber('report')->name('reports.destroy');

    Route::get('/prayer-intentions', [AdminPrayerIntentionController::class, 'index'])->name('prayer-intentions.index');
    Route::post('/prayer-intentions/{intention}/prayed', [AdminPrayerIntentionController::class, 'markPrayed'])->whereNumber('intention')->name('prayer-intentions.prayed');

    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::get('/members/{member}', [MemberController::class, 'show'])->whereNumber('member')->name('members.show');
    Route::post('/members/{member}/approve', [MemberController::class, 'approve'])->whereNumber('member')->name('members.approve');
    Route::post('/members/{member}/reject', [MemberController::class, 'reject'])->whereNumber('member')->name('members.reject');
    Route::post('/members/{member}/info', [MemberController::class, 'requestInfo'])->whereNumber('member')->name('members.info');
    Route::post('/members/{member}/allocate', [MemberController::class, 'allocate'])->whereNumber('member')->name('members.allocate');
    Route::delete('/members/{member}', [MemberController::class, 'destroy'])->whereNumber('member')->name('members.destroy');

    Route::get('/mphakati', [MphakatiController::class, 'index'])->name('mphakati.index');
    Route::post('/mphakati/bulk', [MphakatiController::class, 'bulkAssign'])->name('mphakati.bulk');
    Route::post('/mphakati/{member}/assign', [MphakatiController::class, 'assign'])->whereNumber('member')->name('mphakati.assign');

    Route::get('/elections', [ElectionController::class, 'index'])->name('elections.index');
    Route::get('/elections/create', [ElectionController::class, 'create'])->name('elections.create');
    Route::post('/elections', [ElectionController::class, 'store'])->name('elections.store');
    Route::get('/elections/{election}/edit', [ElectionController::class, 'edit'])->whereNumber('election')->name('elections.edit');
    Route::put('/elections/{election}', [ElectionController::class, 'update'])->whereNumber('election')->name('elections.update');
    Route::delete('/elections/{election}', [ElectionController::class, 'destroy'])->whereNumber('election')->name('elections.destroy');
    Route::post('/elections/{election}/open', [ElectionController::class, 'open'])->whereNumber('election')->name('elections.open');
    Route::post('/elections/{election}/close', [ElectionController::class, 'close'])->whereNumber('election')->name('elections.close');
    Route::post('/elections/{election}/verify', [ElectionController::class, 'verify'])->whereNumber('election')->name('elections.verify');
    Route::post('/elections/{election}/positions', [ElectionController::class, 'storePosition'])->whereNumber('election')->name('elections.positions.store');
    Route::delete('/elections/positions/{position}', [ElectionController::class, 'destroyPosition'])->whereNumber('position')->name('elections.positions.destroy');
    Route::post('/elections/positions/{position}/candidates', [ElectionController::class, 'storeCandidate'])->whereNumber('position')->name('elections.positions.candidates.store');
    Route::delete('/elections/candidates/{candidate}', [ElectionController::class, 'destroyCandidate'])->whereNumber('candidate')->name('elections.candidates.destroy');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('/contacts/{message}/read', [ContactController::class, 'markRead'])->whereNumber('message')->name('contacts.read');
    Route::delete('/contacts/{message}', [ContactController::class, 'destroy'])->whereNumber('message')->name('contacts.destroy');
});
