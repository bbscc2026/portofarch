<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\SiteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->seed(SiteSeeder::class);
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function pages(): array
    {
        return [
            'home' => ['/', 'All projects (6)'],
            'projects' => ['/projects', 'Alliance Française Academy'],
            'project' => ['/projects/alliance-francaise-academy-jeddah', 'Hayy Jameel, Jeddah'],
            'studio' => ['/studio', 'Profile'],
            'services' => ['/services', 'Interior Architecture'],
            'contact' => ['/contact', 'Start a project'],
        ];
    }

    #[DataProvider('pages')]
    public function test_public_pages_render(string $uri, string $expected): void
    {
        $this->get($uri)->assertOk()->assertSee($expected);
    }

    public function test_home_slider_starts_with_the_studio_film(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSeeInOrder(['<video data-slide-video', 'media/hero.webm', 'media/hero.mp4', 'alliance-francaise-01.webp'], false)
            ->assertSee('The Nest — Residential')
            ->assertSee('We design')
            ->assertSee('turn a language school into a voyage across the Red Sea');
    }

    public function test_home_slider_works_without_a_video(): void
    {
        Setting::where('key', 'hero_video_mp4')->update(['value' => '']);

        $this->get('/')->assertOk()->assertDontSee('<video', false)->assertSee('alliance-francaise-01.webp', false);
    }

    public function test_structured_data_is_valid_json(): void
    {
        $html = $this->get('/')->getContent();

        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $match);
        $data = json_decode($match[1] ?? '', true);

        $this->assertSame('https://schema.org', $data['@context'] ?? null);
        $this->assertSame('Port of Arch', $data['name'] ?? null);
    }

    public function test_highlight_markup_is_escaped_and_styled(): void
    {
        $this->assertSame('a <em class="accent">b</em> &lt;i&gt;', (string) rich('a *b* <i>'));
    }

    public function test_projects_can_be_filtered_by_category(): void
    {
        $this->get('/projects?category=Retail')
            ->assertOk()
            ->assertSee('Hair &amp; Beyond', false)
            ->assertDontSee('Seasons');
    }

    public function test_unpublished_projects_are_hidden(): void
    {
        Project::where('slug', 'seasons')->update(['is_published' => false]);

        $this->get('/projects/seasons')->assertNotFound();
        $this->get('/projects')->assertDontSee('Seasons');
    }

    public function test_old_wordpress_urls_redirect(): void
    {
        $this->get('/about-us')->assertRedirect('/studio')->assertStatus(301);
        $this->get('/property')->assertRedirect('/projects')->assertStatus(301);
    }

    public function test_sitemap_lists_projects(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('projects.show', 'hair-and-beyond-emaar-square'));
    }

    public function test_contact_form_stores_enquiry_and_notifies_studio(): void
    {
        Mail::fake();

        $this->post('/contact', [
            'name' => 'Sara Test',
            'email' => 'sara@example.com',
            'phone' => '+966 50 000 0000',
            'project_type' => 'Interior design',
            'message' => 'We are planning a new café interior in Jeddah.',
        ])->assertRedirect('/contact')->assertSessionHas('sent');

        $this->assertDatabaseHas(ContactMessage::class, ['email' => 'sara@example.com', 'read_at' => null]);
    }

    public function test_contact_form_validates_and_blocks_bots(): void
    {
        $this->post('/contact', [])->assertSessionHasErrors(['name', 'email', 'message']);

        $this->post('/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'Buy cheap things now please',
            'website' => 'http://spam.test',
        ])->assertSessionHasErrors('website');

        $this->assertDatabaseCount(ContactMessage::class, 0);
    }

    public function test_admin_requires_login_and_lists_projects(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');

        $this->actingAs(User::factory()->create())
            ->get('/admin/projects')
            ->assertOk()
            ->assertSee('Alliance Française Academy');
    }
}
