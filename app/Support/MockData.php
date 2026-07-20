<?php

namespace App\Support;

class MockData
{
    /**
     * Get list of categories and their subcategories.
     */
    public static function getCategories(): array
    {
        return [
            'india' => [
                'name' => 'भारत',
                'subcategories' => ['राष्ट्रीय समाचार', 'राज्य समाचार', 'संसद बहस', 'चुनाव']
            ],
            'world' => [
                'name' => 'विदेश',
                'subcategories' => ['अमेरिका और कनाडा', 'यूरोप', 'एशिया', 'मध्य पूर्व']
            ],
            'politics' => [
                'name' => 'राजनीति',
                'subcategories' => ['चुनाव', 'नीतियां', 'संसद', 'बहस']
            ],
            'business' => [
                'name' => 'व्यापार',
                'subcategories' => ['बाज़ार', 'अर्थव्यवस्था', 'स्टार्टअप', 'व्यक्तिगत वित्त']
            ],
            'technology' => [
                'name' => 'तकनीकी',
                'subcategories' => ['एआई', 'गैजेट्स', 'सॉफ्टवेयर', 'साइबर सुरक्षा']
            ],
            'education' => [
                'name' => 'शिक्षा',
                'subcategories' => ['प्रवेश', 'परीक्षा', 'करियर', 'ई-लर्निंग']
            ],
            'entertainment' => [
                'name' => 'मनोरंजन',
                'subcategories' => ['बॉलीवुड', 'हॉलीवुड', 'वेब सीरीज', 'समीक्षाएं']
            ],
            'sports' => [
                'name' => 'खेल',
                'subcategories' => ['क्रिकेट', 'फुटबॉल', 'ओलंपिक', 'टेनिस']
            ],
            'health' => [
                'name' => 'स्वास्थ्य',
                'subcategories' => ['वेलनेस', 'चिकित्सा', 'फिटनेस', 'मानसिक स्वास्थ्य']
            ],
            'lifestyle' => [
                'name' => 'लाइफस्टाइल',
                'subcategories' => ['फैशन', 'भोजन', 'रिश्ते', 'डिजाइन']
            ],
            'travel' => [
                'name' => 'यात्रा',
                'subcategories' => ['गंतव्य', 'गाइड', 'टिप्स', 'स्टे']
            ],
            'opinion' => [
                'name' => 'विचार',
                'subcategories' => ['संपादकीय', 'कॉलम', 'पाठकों की आवाज़']
            ],
        ];
    }

    /**
     * Get stock index placeholders.
     */
    public static function getStocks(): array
    {
        return [
            ['name' => 'NIFTY 50', 'value' => '24,380.15', 'change' => '+156.40', 'pct' => '+0.65%', 'up' => true],
            ['name' => 'SENSEX', 'value' => '79,986.30', 'change' => '+521.80', 'pct' => '+0.66%', 'up' => true],
            ['name' => 'NIFTY BANK', 'value' => '52,410.75', 'change' => '-112.30', 'pct' => '-0.21%', 'up' => false],
            ['name' => 'DOW JONES', 'value' => '39,122.10', 'change' => '+245.15', 'pct' => '+0.63%', 'up' => true],
            ['name' => 'NASDAQ', 'value' => '17,732.60', 'change' => '+180.20', 'pct' => '+1.03%', 'up' => true],
        ];
    }

    /**
     * Get current weather forecast simulation.
     */
    public static function getWeather(): array
    {
        $siteSettings = \App\Models\Setting::first();
        $apiKey = $siteSettings->weather_api_key ?? env('WEATHER_API_KEY');
        $citiesString = $siteSettings->weather_locations ?? 'Dehradun, Haridwar, Nainital, New Delhi';
        $cities = array_filter(array_map('trim', explode(',', $citiesString)));

        if (empty($apiKey)) {
            $simulatedConditions = [
                ['temp' => '24°C', 'condition' => 'आंशिक रूप से बादल', 'icon' => 'fa-cloud-sun'],
                ['temp' => '28°C', 'condition' => 'धूप', 'icon' => 'fa-sun'],
                ['temp' => '22°C', 'condition' => 'हवादार', 'icon' => 'fa-wind'],
                ['temp' => '26°C', 'condition' => 'साफ मौसम', 'icon' => 'fa-sun'],
            ];
            $result = [];
            $i = 0;
            foreach ($cities as $city) {
                $cond = $simulatedConditions[$i % count($simulatedConditions)];
                $result[$city] = $cond;
                $i++;
            }
            return $result;
        }

        return \Illuminate\Support\Facades\Cache::remember('live_weather_data', 1800, function () use ($apiKey, $cities) {
            $weatherData = [];

            foreach ($cities as $city) {
                try {
                    $response = \Illuminate\Support\Facades\Http::get("http://api.weatherapi.com/v1/current.json", [
                        'key' => $apiKey,
                        'q' => $city,
                        'aqi' => 'no'
                    ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        $conditionCode = $data['current']['condition']['code'];
                        $weatherData[$city] = [
                            'temp' => round($data['current']['temp_c']) . '°C',
                            'condition' => $data['current']['condition']['text'],
                            'icon' => self::getWeatherIcon($conditionCode),
                        ];
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            // Fallback if API calls failed
            if (empty($weatherData)) {
                return [
                    'Delhi' => ['temp' => '34°C', 'condition' => 'आंशिक रूप से बादल', 'icon' => 'fa-cloud-sun'],
                    'Mumbai' => ['temp' => '29°C', 'condition' => 'भारी बारिश', 'icon' => 'fa-cloud-showers-heavy'],
                    'Bengaluru' => ['temp' => '24°C', 'condition' => 'हवादार', 'icon' => 'fa-wind'],
                    'London' => ['temp' => '18°C', 'condition' => 'बूंदाबांदी', 'icon' => 'fa-cloud-rain'],
                    'New York' => ['temp' => '27°C', 'condition' => 'धूप', 'icon' => 'fa-sun'],
                ];
            }

            return $weatherData;
        });
    }

    /**
     * Get weather for a specific city.
     */
    public static function getCityWeather(string $city): ?array
    {
        $allWeather = self::getWeather();
        
        foreach ($allWeather as $name => $data) {
            if (strtolower($name) === strtolower($city)) {
                return $data;
            }
        }
        
        $apiKey = env('WEATHER_API_KEY');
        if (!empty($apiKey)) {
            return \Illuminate\Support\Facades\Cache::remember('weather_' . strtolower(str_replace(' ', '_', $city)), 1800, function () use ($apiKey, $city) {
                try {
                    $response = \Illuminate\Support\Facades\Http::get("http://api.weatherapi.com/v1/current.json", [
                        'key' => $apiKey,
                        'q' => $city,
                        'aqi' => 'no'
                    ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        $conditionCode = $data['current']['condition']['code'];
                        return [
                            'temp' => round($data['current']['temp_c']) . '°C',
                            'condition' => $data['current']['condition']['text'],
                            'icon' => self::getWeatherIcon($conditionCode),
                        ];
                    }
                } catch (\Exception $e) {
                    // Ignore
                }
                return null;
            });
        }
        
        return null;
    }

    /**
     * Helper to map WeatherAPI condition codes to FontAwesome icons
     */
    private static function getWeatherIcon(int $code): string
    {
        if ($code == 1000) return 'fa-sun'; // Sunny
        if (in_array($code, [1003, 1006, 1009])) return 'fa-cloud-sun'; // Partly Cloudy
        if (in_array($code, [1030, 1135, 1147])) return 'fa-smog'; // Fog/Mist
        if (in_array($code, [1063, 1180, 1183, 1186, 1189, 1240])) return 'fa-cloud-rain'; // Light rain
        if (in_array($code, [1087, 1273, 1276])) return 'fa-cloud-showers-water'; // Thunderstorm
        return 'fa-cloud'; // Default cloudy
    }

    /**
     * Get trending search tags dynamically from database articles.
     */
    public static function getTrendingTags(): array
    {
        try {
            $allTags = \App\Models\Article::pluck('tags')
                ->filter()
                ->flatMap(function($tagStr) {
                    return array_map('trim', explode(',', $tagStr));
                })
                ->filter()
                ->groupBy(function($tag) {
                    return strtolower($tag);
                })
                ->map(function($group) {
                    return [
                        'name' => $group->first(),
                        'count' => $group->count()
                    ];
                })
                ->sortByDesc('count')
                ->take(10)
                ->pluck('name')
                ->toArray();
                
            if (!empty($allTags)) {
                return $allTags;
            }
        } catch (\Exception $e) {
            // Ignore database issues
        }

        return [];
    }

    /**
     * Get list of simulated authors.
     */
    public static function getAuthors(): array
    {
        return [
            'rajesh-sharma' => [
                'name' => 'Rajesh Sharma',
                'title' => 'Senior Political Editor',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80',
                'bio' => 'Rajesh Sharma has covered Indian politics for over two decades. Previously with leading national dailies, he specializes in coalition governments and policy reform.',
                'twitter' => '@rajeshpolitics',
                'articles_count' => 142
            ],
            'ananya-sen' => [
                'name' => 'Ananya Sen',
                'title' => 'Technology Analyst & Reporter',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80',
                'bio' => 'Ananya covers emerging tech, AI governance, and consumer hardware. She is a computer science graduate and writes the weekly "Future Shock" column.',
                'twitter' => '@ananyatech',
                'articles_count' => 88
            ],
            'vikram-malhotra' => [
                'name' => 'Vikram Malhotra',
                'title' => 'Chief Business Correspondent',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80',
                'bio' => 'Vikram analyzes macroeconomic trends, financial markets, and business policy. He holds an MBA from LSE and is a former investment research analyst.',
                'twitter' => '@vikrambusiness',
                'articles_count' => 205
            ],
            'priya-gopal' => [
                'name' => 'Priya Gopal',
                'title' => 'Lifestyle & Wellness Columnist',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=150&q=80',
                'bio' => 'Priya focuses on mental health, modern relationships, travel, and sustainable design. She is a certified nutritionist and yoga practitioner.',
                'twitter' => '@priyawellness',
                'articles_count' => 64
            ],
        ];
    }

    /**
     * Get all high-fidelity news articles.
     */
    public static function getArticles(): array
    {
        $authors = self::getAuthors();
        
        return [
            1 => [
                'id' => 1,
                'slug' => 'india-union-budget-2026-analysis',
                'title' => 'Union Budget 2026 Focuses on Green Infrastructure, Middle-Class Tax Relief & Tech Subsidies',
                'subtitle' => 'Finance Minister outlines a roadmap for a resilient digital economy and zero-carbon infrastructure goals.',
                'summary' => 'The Union Budget 2026 introduces major structural reforms targeting climate resilience, artificial intelligence research grants, and substantial restructuring of personal income tax slabs to boost household savings.',
                'content' => '<p>The Finance Minister presented the Union Budget for fiscal year 2026-27 in Parliament today, laying down a comprehensive fiscal plan centered around sustainable growth, digital equity, and structural relief. With an aim to sustain a 7% GDP growth rate, the budget commits historic capital expenditure allocations for energy transition and high-speed rail networks.</p>
                             <h4>Major Tax Slab Adjustments</h4>
                             <p>In a move welcomed by millions of salaried professionals, the new tax regime has been simplified further. The threshold for zero tax liability has been raised, and the standard deduction sees an upward revision. Financial experts suggest this will leave more disposable income in the hands of the middle class, driving consumption in urban and semi-urban markets.</p>
                             <blockquote>"This budget bridges the gap between digital innovation and physical infrastructure while keeping fiscal deficit targets tightly aligned with long-term stability goals." - Finance Minister</blockquote>
                             <h4>Accelerating Tech and Green Energy</h4>
                             <p>An initial corpus of ₹50,000 crores has been approved for the National AI Mission, focusing on local GPU clusters and language models for agriculture and healthcare. Furthermore, green hydrogen projects and solar rooftop installations receive extended customs duty exemptions to accelerate the clean energy shift.</p>
                             <p>Opposition leaders, however, critiqued the budget for not doing enough to address immediate rural employment concerns, calling for a more direct subsidy approach rather than credit-linked capital programs.</p>',
                'category' => 'politics',
                'subcategory' => 'Policy',
                'author_key' => 'rajesh-sharma',
                'author' => $authors['rajesh-sharma'],
                'image' => '/assets/images/hero.png', // local asset we will generate
                'read_time' => '5 min read',
                'views' => '45.2K',
                'published_at' => 'July 11, 2026 09:30 AM',
                'updated_at' => 'July 11, 2026 11:15 AM',
                'tags' => ['Budget2026', 'Politics', 'CleanEnergy'],
                'is_featured' => true,
                'is_breaking' => true,
            ],
            2 => [
                'id' => 2,
                'slug' => 'global-ai-summit-safety-guidelines',
                'title' => 'Global AI Summit in Geneva Establishes Strict Inter-Governmental Safety Guidelines',
                'subtitle' => '32 nations sign the Geneva AI Accord, agreeing on audit requirements for frontier models.',
                'summary' => 'At the annual safety convention, leaders finalized a legal framework requiring multi-layered auditing for models exceeding 10^26 FLOPs, sparking debate among tech giants.',
                'content' => '<p>Delegates from 32 countries compiled the landmark Geneva Accord on Artificial Intelligence. The agreement mandates independent third-party audits before major commercial deployments of frontier generative models, focusing on cybersecurity vulnerabilities and autonomous capabilities.</p>',
                'category' => 'technology',
                'subcategory' => 'AI',
                'author_key' => 'ananya-sen',
                'author' => $authors['ananya-sen'],
                'image' => '/ai_summit_geneva_banner_1783929961595.jpg',
                'read_time' => '4 min read',
                'views' => '28.9K',
                'published_at' => 'July 11, 2026 12:45 PM',
                'updated_at' => 'July 11, 2026 12:45 PM',
                'tags' => ['AIEvolution', 'GlobalTrade', 'Software'],
                'is_featured' => false,
                'is_breaking' => false,
            ],
            3 => [
                'id' => 3,
                'slug' => 'market-rally-nifty-hits-record-high',
                'title' => 'Market Rally: Nifty Hits Lifetime High as IT and Banking Stocks Surge Post Budget',
                'subtitle' => 'Sensex breaches 80,000 mark as investor confidence returns after clear structural announcements.',
                'summary' => 'Capital markets witnessed stellar buying interest across sectors, led by tech infrastructure developers and private banking giants following the government\'s investment commitments.',
                'content' => '<p>Stock markets surged in early trade, taking cue from the positive capital investments outlined in the federal budget. Institutional foreign investors turned net buyers after three weeks of profit-taking.</p>',
                'category' => 'business',
                'subcategory' => 'Markets',
                'author_key' => 'vikram-malhotra',
                'author' => $authors['vikram-malhotra'],
                'image' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=800&q=80',
                'read_time' => '3 min read',
                'views' => '34.1K',
                'published_at' => 'July 11, 2026 10:15 AM',
                'updated_at' => 'July 11, 2026 10:30 AM',
                'tags' => ['Budget2026', 'InflationUpdate', 'GlobalTrade'],
                'is_featured' => false,
                'is_breaking' => false,
            ],
            4 => [
                'id' => 4,
                'slug' => 'cricket-championship-final-thriller',
                'title' => 'Cricket Cup: India Secures Dramatic Last-Ball Victory Against Australia in Finals',
                'subtitle' => 'An explosive partnership in the death overs guides the team to lift the historic trophy.',
                'summary' => 'In an epic chase of 342 runs, India clinched the title in front of a packed stadium in Melbourne with outstanding performances from the middle-order batsmen.',
                'content' => '<p>Chasing a mammoth target, the top order fell early, but the middle-order showed incredible nerves, bringing the equation to 12 runs required off the final over, winning on the final delivery.</p>',
                'category' => 'sports',
                'subcategory' => 'Cricket',
                'author_key' => 'rajesh-sharma',
                'author' => $authors['rajesh-sharma'],
                'image' => 'https://images.unsplash.com/photo-1531415080290-bc98545ab3ef?auto=format&fit=crop&w=800&q=80',
                'read_time' => '6 min read',
                'views' => '58.4K',
                'published_at' => 'July 10, 2026 08:30 PM',
                'updated_at' => 'July 10, 2026 08:30 PM',
                'tags' => ['CricketCup', 'Sports'],
                'is_featured' => false,
                'is_breaking' => false,
            ],
            5 => [
                'id' => 5,
                'slug' => 'wellness-habits-digital-detox',
                'title' => 'The Digital Reset: 5 Micro-Habits to Reclaim Focus in an Era of Constant Notifications',
                'subtitle' => 'How tiny changes to your notification settings and morning routines can lower cortisol levels.',
                'summary' => 'Our constant connection to workplace messaging and social channels is creating chronic alertness. A wellness guide on introducing active digital barriers.',
                'content' => '<p>Priya Gopal explores how small boundaries, like setting gray-scale screens after 9 PM, can drastically improve sleep cycles and mental stamina during work hours.</p>',
                'category' => 'health',
                'subcategory' => 'Wellness',
                'author_key' => 'priya-gopal',
                'author' => $authors['priya-gopal'],
                'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                'read_time' => '4 min read',
                'views' => '19.3K',
                'published_at' => 'July 11, 2026 08:00 AM',
                'updated_at' => 'July 11, 2026 08:00 AM',
                'tags' => ['CleanEnergy'],
                'is_featured' => false,
                'is_breaking' => false,
            ],
            6 => [
                'id' => 6,
                'slug' => 'entertainment-awards-blockbuster-sweeps',
                'title' => 'Sci-Fi Epic "Centauri" Sweeps National Film Awards with 8 Major Category Wins',
                'subtitle' => 'The ground-breaking cinematic achievement secures Best Director, Visual Effects, and Best Picture.',
                'summary' => 'The highly acclaimed interstellar drama dominated the awards night, setting records for technical categories and solidifying a new standard for national visual arts.',
                'content' => '<p>The jury announced the winners, praising "Centauri" for its narrative depth and revolutionary CGI elements that were completed entirely by domestic visual effects studios.</p>',
                'category' => 'entertainment',
                'subcategory' => 'Web Series',
                'author_key' => 'priya-gopal',
                'author' => $authors['priya-gopal'],
                'image' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?auto=format&fit=crop&w=800&q=80',
                'read_time' => '3 min read',
                'views' => '22.7K',
                'published_at' => 'July 10, 2026 10:00 PM',
                'updated_at' => 'July 10, 2026 10:00 PM',
                'tags' => ['MetaverseNext'],
                'is_featured' => false,
                'is_breaking' => false,
            ],
            7 => [
                'id' => 7,
                'slug' => 'world-summit-climate-adaptation-targets',
                'title' => 'World Leaders Establish Ambitious Coasts Resilience Fund at Annual Climate Summit',
                'subtitle' => 'A $120 Billion global commitment will finance sea walls and climate-resilient agriculture.',
                'summary' => 'With rising temperatures endangering low-lying island states, nations finalized funding structures to protect coastal economies over the next decade.',
                'content' => '<p>The COP summit concluded with an historic resolution. Developed nations pledged a capital pool of $120 Billion to assist vulnerable coastal communities with infrastructure adaptation.</p>',
                'category' => 'world',
                'subcategory' => 'Asia',
                'author_key' => 'rajesh-sharma',
                'author' => $authors['rajesh-sharma'],
                'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=800&q=80',
                'read_time' => '5 min read',
                'views' => '15.8K',
                'published_at' => 'July 11, 2026 07:15 AM',
                'updated_at' => 'July 11, 2026 07:15 AM',
                'tags' => ['ClimateSummit', 'CleanEnergy'],
                'is_featured' => false,
                'is_breaking' => false,
            ],
            8 => [
                'id' => 8,
                'slug' => 'education-reforms-flexible-degree-structures',
                'title' => 'National Education Council Mandates Highly Flexible Multi-Disciplinary Degree Options',
                'subtitle' => 'Students will soon have options to major in Computer Science with minors in Music or History.',
                'summary' => 'New academic standards aim to break vertical silos, encouraging cross-disciplinary research and standardizing transfer credits across state universities.',
                'content' => '<p>The council published its new curriculum framework, outlining credit transfer guidelines and supporting flexible degree durations to help working professionals reskill.</p>',
                'category' => 'education',
                'subcategory' => 'Admissions',
                'author_key' => 'ananya-sen',
                'author' => $authors['ananya-sen'],
                'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=800&q=80',
                'read_time' => '4 min read',
                'views' => '12.4K',
                'published_at' => 'July 11, 2026 06:30 AM',
                'updated_at' => 'July 11, 2026 06:30 AM',
                'tags' => ['AIEvolution'],
                'is_featured' => false,
                'is_breaking' => false,
            ],
            9 => [
                'id' => 9,
                'slug' => 'travel-eco-tourism-spots',
                'title' => 'Top Sustainable Resorts Redefining Eco-Tourism in the Himalayas for 2026',
                'subtitle' => 'Zero-waste luxury chalets combine traditional architecture with modern geothermal solar systems.',
                'summary' => 'As eco-consciousness peaks, these properties offer zero carbon footprint stays, organic farming workshops, and high-altitude trekking guides.',
                'content' => '<p>Travel editor Priya Gopal compiles a review of five pristine retreats in Himachal and Ladakh that generate 100% of their power from onsite microgrids.</p>',
                'category' => 'travel',
                'subcategory' => 'Destinations',
                'author_key' => 'priya-gopal',
                'author' => $authors['priya-gopal'],
                'image' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80',
                'read_time' => '5 min read',
                'views' => '25.1K',
                'published_at' => 'July 9, 2026 11:00 AM',
                'updated_at' => 'July 9, 2026 11:00 AM',
                'tags' => ['CleanEnergy'],
                'is_featured' => false,
                'is_breaking' => false,
            ],
            10 => [
                'id' => 10,
                'slug' => 'tech-quantum-computing-breakthrough',
                'title' => 'Researchers Claim Critical Room Temperature Superconductor Breakthrough for Quantum Cells',
                'subtitle' => 'New polymer blend allows stable magnetic fields at 15°C, potentially scaling qubit processing.',
                'summary' => 'A team of material scientists published findings of a synthesized material that retains superconductivity under normal room conditions, a major milestone in physics.',
                'content' => '<p>The theoretical breakthrough, if validated through replication, could reduce quantum refrigeration costs by 90% and lead to portable supercomputing units within the decade.</p>',
                'category' => 'technology',
                'subcategory' => 'Cybersecurity',
                'author_key' => 'ananya-sen',
                'author' => $authors['ananya-sen'],
                'image' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?auto=format&fit=crop&w=800&q=80',
                'read_time' => '6 min read',
                'views' => '31.2K',
                'published_at' => 'July 11, 2026 05:45 AM',
                'updated_at' => 'July 11, 2026 05:45 AM',
                'tags' => ['AIEvolution', 'Software'],
                'is_featured' => false,
                'is_breaking' => false,
            ],
        ];
    }

    /**
     * Get web stories (Instagram format cards)
     */
    public static function getWebStories(): array
    {
        return [
            ['id' => 1, 'title' => 'Top 5 Budget Slabs 2026', 'image' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=300&q=80', 'user' => 'Rajesh S.', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=80&q=80'],
            ['id' => 2, 'title' => 'CRICKET CHAMPIONS: Best Moments', 'image' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=300&q=80', 'user' => 'Sports Desk', 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=80&q=80'],
            ['id' => 3, 'title' => 'AI Safety Accord Explained', 'image' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=300&q=80', 'user' => 'Ananya Sen', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=80&q=80'],
            ['id' => 4, 'title' => 'Best Himalayan Eco Resorts', 'image' => 'https://images.unsplash.com/photo-1454496522488-7a8e488e8606?auto=format&fit=crop&w=300&q=80', 'user' => 'Priya Gopal', 'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=80&q=80'],
            ['id' => 5, 'title' => 'Next-Gen Tesla FSD Test Run', 'image' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=300&q=80', 'user' => 'Autotech', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=80&q=80'],
        ];
    }

    /**
     * Get list of video gallery posts.
     */
    public static function getVideos(): array
    {
        return [
            1 => [
                'id' => 1,
                'title' => 'Exclusive Interview: Finance Minister Breaks Down Tax Slab Changes Post Budget Presentation',
                'youtube_id' => 'dQw4w9WgXcQ', // Placeholder video
                'duration' => '12:45',
                'views' => '89K views',
                'category' => 'Politics',
                'image' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?auto=format&fit=crop&w=600&q=80',
                'date' => '2 hours ago'
            ],
            2 => [
                'id' => 2,
                'title' => 'Watch: Real-Time Demonstration of Room Temp Superconductor magnetic levitation cell',
                'youtube_id' => 'dQw4w9WgXcQ',
                'duration' => '4:20',
                'views' => '156K views',
                'category' => 'Technology',
                'image' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?auto=format&fit=crop&w=600&q=80',
                'date' => '5 hours ago'
            ],
            3 => [
                'id' => 3,
                'title' => 'Melbourne Stadium Roars: Winning Moments of the Cricket World Cup Final Chase',
                'youtube_id' => 'dQw4w9WgXcQ',
                'duration' => '8:15',
                'views' => '320K views',
                'category' => 'Sports',
                'image' => 'https://images.unsplash.com/photo-1540747737956-37872404a8de?auto=format&fit=crop&w=600&q=80',
                'date' => '1 day ago'
            ],
            4 => [
                'id' => 4,
                'title' => 'Behind the Scenes: CGI Walkthrough of Sci-Fi Epic "Centauri" Visuals',
                'youtube_id' => 'dQw4w9WgXcQ',
                'duration' => '15:30',
                'views' => '45K views',
                'category' => 'Entertainment',
                'image' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?auto=format&fit=crop&w=600&q=80',
                'date' => '1 day ago'
            ],
        ];
    }

    /**
     * Get masonry photo albums.
     */
    public static function getPhotos(): array
    {
        return [
            ['id' => 1, 'title' => 'Parliament Budget Session Highlights in Frames', 'image' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?auto=format&fit=crop&w=800&q=80', 'size' => 'masonry-wide', 'category' => 'Politics', 'count' => 12],
            ['id' => 2, 'title' => 'Melbourne Celebrations: India Lifts the Gold Cup', 'image' => 'https://images.unsplash.com/photo-1531415080290-bc98545ab3ef?auto=format&fit=crop&w=800&q=80', 'size' => 'masonry-tall', 'category' => 'Sports', 'count' => 18],
            ['id' => 3, 'title' => 'Geneva Summit: Inside the AI Safety Convention', 'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80', 'size' => 'normal', 'category' => 'Technology', 'count' => 8],
            ['id' => 4, 'title' => 'Pristine Ladakh: Sustainable Eco Resorts Review', 'image' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80', 'size' => 'normal', 'category' => 'Travel', 'count' => 15],
            ['id' => 5, 'title' => 'Red Carpet Glamour: National Film Awards Gala Night', 'image' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=800&q=80', 'size' => 'masonry-wide', 'category' => 'Entertainment', 'count' => 24],
        ];
    }

    /**
     * Get live blog timeline events.
     */
    public static function getLiveEvents(): array
    {
        return [
            [
                'time' => '14:20 PM',
                'title' => 'Opposition Leaders Stage Walkout Over Agri Allocations',
                'content' => 'Prominent leaders from opposition parties staged a brief protest and walked out of the lower house, stating that rural employment incentives in the budget are insufficient.',
                'image' => null,
                'tag' => 'Budget2026'
            ],
            [
                'time' => '13:45 PM',
                'title' => 'Automotive Shares Jump up to 6% on EV Tax Exemption Extensions',
                'content' => 'Shares of key electric vehicle manufacturers and lithium-ion cell developers surged rapidly following announcements of zero customs duty extensions on critical materials.',
                'image' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=600&q=80',
                'tag' => 'Markets'
            ],
            [
                'time' => '13:10 PM',
                'title' => 'Stock Indices Refresh Lifetimes Highs: Nifty Touches 24,400',
                'content' => 'Strong institutional inflows and high retail investor enthusiasm push the benchmark index past previous resistance levels, backed by IT infrastructure buying.',
                'image' => null,
                'tag' => 'Markets'
            ],
            [
                'time' => '12:30 PM',
                'title' => 'National AI Mission Allocated ₹50,000 Crores',
                'content' => 'The Union Cabinet approves immediate capital disbursement. The funds will support academic supercomputing grids and start-up grants for localized NLP models in Indian languages.',
                'image' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=600&q=80',
                'tag' => 'AI'
            ],
        ];
    }

    /**
     * Get mock comments.
     */
    public static function getComments(): array
    {
        return [
            ['name' => 'Aarav Mehta', 'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=100&q=80', 'date' => 'July 11, 2026 10:45 AM', 'comment' => 'The changes to the income tax standard deductions are a solid step forward. Leaving more savings with salaried workers will definitely boost market liquid capital.'],
            ['name' => 'Ritu Sen', 'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=100&q=80', 'date' => 'July 11, 2026 11:20 AM', 'comment' => 'I am really glad to see concrete budget investments allocated for the National AI Mission. Building national hardware clusters is critical for software independence.'],
            ['name' => 'John Doe', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80', 'date' => 'July 11, 2026 12:05 PM', 'comment' => 'Although the green energy duty exemption is nice, there should be more support for solar battery manufacturing domestically to lower upfront installation prices.'],
        ];
    }
}
