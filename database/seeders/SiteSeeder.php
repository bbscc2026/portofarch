<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Faq;
use App\Models\PressArticle;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Seeds the site with content rewritten from the previous portofarch.com
 * and the studio's published project write-ups (Archello, The Design Story).
 */
class SiteSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        $this->seedProjects();
        $this->seedServices();
        $this->seedClients();
        $this->seedFaqs();
    }

    private function seedSettings(): void
    {
        $settings = [
            ['site_name', 'Site name', 'Port of Arch'],
            ['tagline', 'Tagline', 'Architecture & interiors, Jeddah'],
            ['hero_statement', 'Home statement', 'We design spaces that carry the *beliefs, tastes and values* of the people who use them.'],
            ['intro', 'Studio introduction', "Port of Arch (POA) is an architecture and interior design studio founded in Jeddah in 2018. We work across education, retail, hospitality, workplace and private interiors — treating every brief as a *single, specific opportunity* rather than a variation on a style.\n\nOur process is built on close collaboration. We listen first, study the site and its climate, then shape spaces that are functional, beautifully made and genuinely connected to the people who inhabit them."],
            ['hero_lines', 'Home hero statements — one per line, split the two rows with |', "We design|spaces with purpose\nWe study|the place first\nWe shape|light & material\nWe build|for the long run"],
            ['founded_year', 'Founded (year)', '2018'],
            ['hero_video_mp4', 'Home slider video — MP4 path (leave empty for no video)', 'media/hero.mp4'],
            ['hero_video_webm', 'Home slider video — WebM path (optional, smaller)', 'media/hero.webm'],
            ['hero_video_poster', 'Home slider video — poster image path', 'media/hero-poster.jpg'],
            ['hero_video_caption', 'Home slider video — caption', 'The Nest — Residential'],
            ['phone', 'Phone', '+966 57 177 0236'],
            ['whatsapp', 'WhatsApp number (digits only)', '966571770236'],
            ['email', 'Email', 'info@portofarch.com'],
            ['address', 'Address', 'Jeddah, Saudi Arabia'],
            ['instagram', 'Instagram URL', ''],
            ['linkedin', 'LinkedIn URL', ''],
            ['youtube', 'YouTube URL', ''],
            ['facebook', 'Facebook URL', ''],
        ];

        foreach ($settings as [$key, $label, $value]) {
            Setting::updateOrCreate(['key' => $key], ['label' => $label, 'value' => $value]);
        }
    }

    private function seedProjects(): void
    {
        $projects = [
            [
                'title' => 'Alliance Française Academy',
                'slug' => 'alliance-francaise-academy-jeddah',
                'category' => 'Education',
                'location' => 'Hayy Jameel, Jeddah',
                'client' => 'Alliance Française',
                'year' => '2024',
                'status' => 'Realised',
                'scope' => 'Interior architecture',
                'credits' => 'Lead designers: Adil Shareef, Anshif Habib · Design team: Salama Umar · Photography: Abdulelah Qutub',
                'excerpt' => 'A language academy shaped by the Red Sea — sinuous curves, ribbed glass and a ship-hull reception for Alliance Française’s first school in Jeddah.',
                'tagline' => 'turn a language school into a voyage across the Red Sea',
                'body' => "Alliance Française’s first educational home in Jeddah sits in Hayy Jameel, the city’s most active cultural district. The brief was a school for language and cultural exchange; our response was to let the nearby Red Sea — for centuries a route for trade, ideas and languages — set the spatial story.\n\nThe programme is compact: four equal classrooms, a director’s office, a main lecture hall and a common area that rises across three levels. The lecture hall looks out over Hayy Jameel’s central square, tying the classroom to the life of the district, while a timber amphitheatre at the heart of the plan gathers the classrooms around a single shared space for students, teachers and visitors.\n\nThere are almost no square corners. Rounded edges keep the eye and the body moving, mirroring the idea of learning as continuous flow. The reception desk is shaped like a ship’s hull; concrete floors carry a wave-like texture; ribbed glass filters daylight into shifting, water-like patterns. A disciplined red-and-white palette carries the institution’s identity, softened by warm wood veneer and planting.\n\nThe result is more than a set of classrooms — it is a meeting point between Saudi and French culture, rooted in the place it stands.",
                'cover' => 'alliance-francaise-01.webp',
                'images' => [
                    ['alliance-francaise-02.webp', 'Amphitheatre seating and classroom fronts', true],
                    ['alliance-francaise-03.webp', 'Circulation with ribbed-glass classroom doors', false],
                    ['alliance-francaise-04.webp', 'Reception', false],
                    ['alliance-francaise-08.webp', 'Ship-hull reception — design visualisation', true],
                    ['alliance-francaise-06.webp', 'Common area — design visualisation', false],
                    ['alliance-francaise-07.webp', 'Entrance and reception — design visualisation', false],
                    ['alliance-francaise-12.webp', 'Timber amphitheatre from above — design visualisation', true],
                    ['alliance-francaise-11.webp', 'Stepped seating and planting — design visualisation', false],
                    ['alliance-francaise-10.webp', 'Arched threshold — design visualisation', false],
                    ['alliance-francaise-05.webp', 'Street frontage, Hayy Jameel — design visualisation', true],
                ],
                'featured' => true,
                'press' => [
                    ['Archello', 'Alliance Française — Port of Arch', 'https://archello.com/project/alliance-francaise-5'],
                    ['The Design Story', 'Sinuous curves and coastal elements in Alliance Française Academy in Jeddah', 'https://www.thedesignstory.com/blog/news/news-sinuous-curves-and-coastal-elements-in-alliance-franaise-academy-in-jeddah'],
                ],
            ],
            [
                'title' => 'Hair & Beyond',
                'slug' => 'hair-and-beyond-emaar-square',
                'category' => 'Retail',
                'location' => 'Emaar Square, Jeddah',
                'client' => 'Hair & Beyond London',
                'year' => null,
                'status' => 'Realised',
                'scope' => 'Interior design',
                'credits' => 'Photography: Abdulelah Qutub',
                'excerpt' => 'A London salon brand in Jeddah, organised around a bold blue capsule that turns two cutting chairs into a private room.',
                'tagline' => 'give two salon chairs a room of their own',
                'body' => "For Hair & Beyond’s salon in Emaar Square, the client asked for a space that felt luxurious without ever getting in the way of a busy working day. We planned the salon as a sequence of clear zones: five cutting chairs, two washing stations, two quiet pedicure areas and four facial treatment rooms on a mezzanine above.\n\nVisitors are welcomed by a wall of retail shelving to the left of the entrance — part display, part architecture — before moving into the main salon, where stations are spaced generously for privacy and comfort. Washing and pedicure areas sit slightly apart, so the noise and pace of the cutting floor never reaches them.\n\nAt the centre stands the project’s signature: a vivid blue capsule housing two cutting chairs. It gives clients who want a more private service a room of their own, and gives the salon an unmistakable focal point against a calm backdrop of stone-textured cladding, warm timber and soft light.\n\nUpstairs, the facial rooms are quiet and dimly lit, separated from the salon floor but clearly part of the same design language.",
                'cover' => 'hair-beyond-01.webp',
                'images' => [
                    ['hair-beyond-02.webp', 'The blue capsule — design visualisation', true],
                    ['hair-beyond-05.webp', 'Reception and retail wall', false],
                    ['hair-beyond-03.webp', 'Waiting lounge — design visualisation', false],
                    ['hair-beyond-04.webp', 'Retail shelving and lounge — design visualisation', true],
                ],
                'featured' => true,
                'press' => [
                    ['Archello', 'Hair & Beyond — Port of Arch', 'https://archello.com/project/hair-beyond'],
                ],
            ],
            [
                'title' => 'Restaurant Interior',
                'slug' => 'restaurant-interior',
                'category' => 'Hospitality',
                'location' => 'Saudi Arabia',
                'status' => 'Concept',
                'scope' => 'Interior design',
                'excerpt' => 'A light-filled dining hall of brass arches, timber screens and soft upholstery.',
                'tagline' => 'let a dining hall breathe between arches of light',
                'body' => "A dining room planned around daylight and rhythm. Slender brass arches divide the hall into intimate bays without closing it off, while perforated timber screens and woven pendants keep the space warm and textured.\n\nTable layouts move between communal and private, so the room works as well for a family lunch as for a quiet dinner for two.",
                'cover' => 'restaurant-01.webp',
                'images' => [
                    ['restaurant-02.webp', 'Main dining hall — design visualisation', true],
                    ['restaurant-03.webp', 'Arched dining bays — design visualisation', true],
                ],
                'featured' => true,
            ],
            [
                'title' => 'Seasons',
                'slug' => 'seasons',
                'category' => 'Hospitality',
                'location' => 'Saudi Arabia',
                'status' => 'Concept',
                'scope' => 'Architecture & landscape',
                'excerpt' => 'An open-air hospitality destination set around water, shade and planting.',
                'tagline' => 'set every table around water and shade',
                'body' => "Seasons is conceived as an outdoor destination that changes with the time of day. A long reflecting pool anchors the site, with dining terraces and shaded pavilions arranged around it so that every table looks out over water and greenery.\n\nTimber, stone and generous canopies keep the architecture calm and climatic — designed for evenings outdoors.",
                'cover' => 'seasons-01.webp',
                'images' => [],
                'featured' => false,
            ],
            [
                'title' => 'Coastal Pavilions',
                'slug' => 'coastal-pavilions',
                'category' => 'Cultural',
                'location' => 'Saudi Arabia',
                'status' => 'Concept',
                'scope' => 'Architecture',
                'excerpt' => 'A cluster of folded white pavilions, low against the landscape.',
                'tagline' => 'fold a village of pavilions into the landscape',
                'body' => "A family of folded, faceted pavilions that sit low in the landscape. Their angled white roofs catch the changing light through the day, while perforated façades filter sun and frame views out to the palms and lawn.\n\nThe pavilions are planned as a loose village — easy to approach from every side and generous with shaded outdoor space.",
                'cover' => 'pavilions-01.webp',
                'images' => [],
                'featured' => false,
            ],
            [
                'title' => 'Commercial Building',
                'slug' => 'commercial-building',
                'category' => 'Commercial',
                'location' => 'Saudi Arabia',
                'status' => 'Concept',
                'scope' => 'Architecture',
                'excerpt' => 'A two-storey street-front building with a colourful, patterned façade.',
                'tagline' => 'make a street-front building impossible to miss',
                'body' => "A compact two-storey commercial building designed to stand out on a busy street. A deep cantilevered roof shades the upper floor, while a patterned, colourful screen gives the frontage its identity and filters light into the interior.\n\nThe ground floor opens fully to the pavement, making the building easy to read and easy to enter.",
                'cover' => 'commercial-01.webp',
                'images' => [],
                'featured' => false,
            ],
        ];

        foreach ($projects as $order => $data) {
            $project = Project::updateOrCreate(['slug' => $data['slug']], [
                'title' => $data['title'],
                'category' => $data['category'],
                'location' => $data['location'],
                'client' => $data['client'] ?? null,
                'year' => $data['year'] ?? null,
                'status' => $data['status'],
                'scope' => $data['scope'],
                'credits' => $data['credits'] ?? null,
                'excerpt' => $data['excerpt'],
                'tagline' => $data['tagline'] ?? null,
                'body' => $data['body'],
                'cover_image' => $this->copyImage($data['cover'], 'projects'),
                'is_featured' => $data['featured'],
                'is_published' => true,
                'sort_order' => $order,
                'meta_description' => $data['excerpt'],
            ]);

            $project->images()->delete();
            foreach ($data['images'] as $index => [$file, $caption, $isWide]) {
                $project->images()->create([
                    'path' => $this->copyImage($file, 'projects'),
                    'caption' => $caption,
                    'is_wide' => $isWide,
                    'sort_order' => $index,
                ]);
            }

            foreach ($data['press'] ?? [] as $index => [$publication, $title, $url]) {
                PressArticle::updateOrCreate(['url' => $url], [
                    'project_id' => $project->id,
                    'publication' => $publication,
                    'title' => $title,
                    'sort_order' => $index,
                ]);
            }
        }
    }

    private function seedServices(): void
    {
        $services = [
            ['Interior Architecture', 'Complete interiors for workplaces, retail, hospitality and education — from space planning to joinery, lighting and finishes.', 'We plan how people move, gather and work, then resolve every surface: bespoke joinery, lighting, materials and furniture. Our interiors are designed to be built — detailed for local trades and maintained easily over years of use.'],
            ['Architecture', 'New buildings and façades shaped by site, climate and the way people will use them.', 'From early massing and feasibility to full design packages, we design buildings that respond to Jeddah’s climate and context — shade, orientation, natural light and material honesty come first.'],
            ['Concept & Visualisation', 'Clear concepts, mood boards and photorealistic 3D visualisation so you see the space before it is built.', 'Every project begins with a concept you can hold on to. We test it through models, material boards and photorealistic renders, making decisions easier and approvals faster.'],
            ['Project Planning & Delivery', 'Drawings, specifications, budgets and site coordination that carry the design through to completion.', 'We prepare construction drawings and specifications, coordinate with consultants and contractors, and stay involved on site so that what is built matches what was designed — on time and on budget.'],
        ];

        foreach ($services as $order => [$title, $summary, $body]) {
            Service::updateOrCreate(['title' => $title], ['summary' => $summary, 'body' => $body, 'sort_order' => $order]);
        }
    }

    private function seedClients(): void
    {
        $clients = [
            ['Art Jameel', 'logo-art-jameel.png', 'https://artjameel.org/'],
            ['Alliance Française', 'logo-alliance-francaise.png', 'https://www.af-ksa.org/en/about/'],
            ['Reviva', 'logo-reviva.png', 'https://reviva.sa/'],
            ['Villa Negra', 'logo-villa-negra.png', null],
            ['Juice World', 'logo-juice-world.png', 'https://juiceworld.com.sa/en/'],
            ['Kabayan', 'logo-kabayan.png', null],
        ];

        foreach ($clients as $order => [$name, $logo, $url]) {
            Client::updateOrCreate(['name' => $name], [
                'logo' => $this->copyImage($logo, 'clients'),
                'url' => $url,
                'sort_order' => $order,
            ]);
        }
    }

    private function seedFaqs(): void
    {
        $faqs = [
            ['Do you offer a free initial consultation?', 'Yes. The first meeting is free — we listen to your brief, visit or review the site and explain how we would approach the project and what it is likely to involve.'],
            ['What kind of projects do you take on?', 'Commercial, retail, hospitality, education and private residential projects — both interiors and architecture. We work on new builds as well as fit-outs of existing spaces.'],
            ['How long does a design project take?', 'It depends on size and complexity. A single interior can take a few weeks to design; a full building can take several months. We agree a clear timeline before we start.'],
            ['Do you provide 3D visualisation?', 'Yes. Photorealistic renders and 3D walkthroughs are part of our design process, so you can see the space before construction begins.'],
            ['Can you work within our budget?', 'Yes. We set the budget together at the start and design to it, choosing materials and details that protect quality where it matters most.'],
            ['Do you only work in Jeddah?', 'We are based in Jeddah and work across Saudi Arabia. Get in touch about projects elsewhere in the region.'],
        ];

        foreach ($faqs as $order => [$question, $answer]) {
            Faq::updateOrCreate(['question' => $question], ['answer' => $answer, 'sort_order' => $order]);
        }
    }

    /**
     * Copy a bundled seed image onto the public disk and return its stored path.
     */
    private function copyImage(string $file, string $folder): string
    {
        $path = "{$folder}/{$file}";

        Storage::disk('public')->put($path, file_get_contents(database_path("seeders/images/{$file}")));

        return $path;
    }
}
