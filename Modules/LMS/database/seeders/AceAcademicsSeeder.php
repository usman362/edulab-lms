<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\LMS\Models\Page;
use Modules\LMS\Models\Testimonial;
use Modules\LMS\Models\Faq;
use Modules\LMS\Models\Category;
use Modules\LMS\Models\General\ThemeSetting;
use Modules\LMS\Models\Hero\Hero;
use Modules\LMS\Models\Slider\Slider;
use Modules\LMS\Models\Auth\Instructor;
use Modules\LMS\Models\Courses\Level;
use Modules\LMS\Models\Courses\Subject;
use Modules\LMS\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class AceAcademicsSeeder extends Seeder
{
    /**
     * Old site image URLs from aceacademic.com.au (Squarespace CDN)
     */
    private array $oldSiteImages = [
        'hero_classroom' => 'https://images.squarespace-cdn.com/content/v1/68b8f49c3f4f4f26c6ed961f/3c748c3a-ecdd-4ffd-9b2a-d233b94ad7d7/adi+smiling+with+students.jpg?format=2500w',
        'turhan' => 'https://images.squarespace-cdn.com/content/v1/68b8f49c3f4f4f26c6ed961f/493f1c38-f433-4f08-940e-70c4aba8f8e3/turhan.jpg?format=1000w',
        'adi_distinguished' => 'https://images.squarespace-cdn.com/content/v1/68b8f49c3f4f4f26c6ed961f/fff51e36-82a6-45d9-a780-36e60df2f471/Adi+Distinguished.jpg?format=1000w',
        'ace_logo' => 'https://images.squarespace-cdn.com/content/v1/68b8f49c3f4f4f26c6ed961f/e619d02c-5078-4bb1-ad23-4adb8f600e17/ChatGPT+Image+Sep+9%2C+2025%2C+04_30_11+PM.png?format=1500w',
        'ace_logo_footer' => 'https://images.squarespace-cdn.com/content/v1/68b8f49c3f4f4f26c6ed961f/42fe64c7-3d9a-4de9-ab6b-addefe396497/Logo.png?format=2500w',
    ];

    /**
     * Download an image from URL and save to LMS storage.
     * Returns the filename if successful, empty string if failed.
     */
    private function downloadImage(string $url, string $folder, string $filename): string
    {
        try {
            $disk = is_tenant_context() ? 'local' : 'LMS';
            $path = "public/{$folder}/{$filename}";

            // Skip if already exists
            if (Storage::disk($disk)->exists($path)) {
                return $filename;
            }

            $response = Http::timeout(30)->get($url);
            if ($response->successful()) {
                Storage::disk($disk)->put($path, $response->body());
                return $filename;
            }
        } catch (\Exception $e) {
            // Silently fail — slider will show placeholder
        }
        return '';
    }

    /**
     * Seed the Ace Academics LMS with brand-specific content
     * matching the old site at aceacademic.com.au exactly.
     */
    public function run(): void
    {
        $this->downloadOldSiteImages();
        $this->seedHeroSliders();
        $this->seedCategories();
        $this->seedTestimonials();
        $this->seedFaqs();
        $this->seedPages();
        $this->seedThemeSettings();
        $this->seedLevels();
        $this->seedSubjects();
        $this->seedInstructors();
    }

    /**
     * Download all images from the old aceacademic.com.au site
     * and store them in the LMS storage directories.
     */
    private function downloadOldSiteImages(): void
    {
        // Download hero slider images
        $this->downloadImage($this->oldSiteImages['hero_classroom'], 'lms/sliders', 'ace-classroom.jpg');
        $this->downloadImage($this->oldSiteImages['adi_distinguished'], 'lms/sliders', 'ace-adi-distinguished.jpg');
        $this->downloadImage($this->oldSiteImages['turhan'], 'lms/sliders', 'ace-turhan.jpg');

        // Download logos
        $this->downloadImage($this->oldSiteImages['ace_logo'], 'lms/logo', 'ace-logo.png');
        $this->downloadImage($this->oldSiteImages['ace_logo_footer'], 'lms/logo', 'ace-logo-footer.png');

        // Download instructor photos
        $this->downloadImage($this->oldSiteImages['turhan'], 'lms/instructors', 'turhan.jpg');
        $this->downloadImage($this->oldSiteImages['adi_distinguished'], 'lms/instructors', 'adi-distinguished.jpg');
    }

    /**
     * Seed hero sliders for homepage banner.
     * Old site hero: "Effort to Excellence. That's how you ACE it." + classroom photo background
     */
    private function seedHeroSliders(): void
    {
        $hero = Hero::updateOrCreate(
            ['title' => 'Ace Academics Hero'],
            [
                'user_id' => 1,
                'theme_id' => 1,
                'title' => 'Ace Academics Hero',
                'status' => 1,
            ]
        );

        $sliders = [
            [
                'hero_id' => $hero->id,
                'title' => "Effort to Excellence.",
                'sub_title' => "That's how you ACE it.",
                'highlight_text' => 'ACE it.',
                'description' => 'Helping students build confidence, achieve top results, and perform when it matters most.',
                'image' => 'ace-classroom.jpg',
                'buttons' => json_encode([
                    'name' => 'Discover More',
                    'link' => '/courses',
                ]),
                'status' => 1,
            ],
            [
                'hero_id' => $hero->id,
                'title' => 'Selective & Scholarship Preparation',
                'sub_title' => 'Expert Tutors, Proven Results',
                'highlight_text' => 'Proven Results',
                'description' => 'From school entry exams to university-level preparation, we provide structured programs that build confidence and deliver results.',
                'image' => 'ace-adi-distinguished.jpg',
                'buttons' => json_encode([
                    'name' => 'Discover More',
                    'link' => '/courses',
                ]),
                'status' => 1,
            ],
            [
                'hero_id' => $hero->id,
                'title' => 'Internal Exam Preparation',
                'sub_title' => 'NAPLAN, ICAS & School Assessments',
                'highlight_text' => 'School Assessments',
                'description' => 'Study systems that support long-term success. High School Assessments & ATAR Externals.',
                'image' => 'ace-turhan.jpg',
                'buttons' => json_encode([
                    'name' => 'Discover More',
                    'link' => '/courses',
                ]),
                'status' => 1,
            ],
        ];

        Slider::where('hero_id', $hero->id)->delete();

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }

    /**
     * Seed course categories — matches 3 programs from old site Programs page.
     */
    private function seedCategories(): void
    {
        $categories = [
            [
                'title' => 'Acceleration Class',
                'slug' => 'acceleration-class',
                'meta_description' => 'Accelerates students beyond the school curriculum. Online video platform for content. Extensive weekly homework.',
            ],
            [
                'title' => 'UCAT Excellence',
                'slug' => 'ucat-excellence',
                'meta_description' => 'On-demand UCAT video lessons covering all sections. Strategy-focused teaching with worked examples and exam techniques. Self-paced learning with clear skill progression and structure.',
            ],
            [
                'title' => 'Selective Exam Preparation',
                'slug' => 'selective-exam-preparation',
                'meta_description' => 'Targeted prep for Queensland and NSW selective school and NAPLAN exams. Weekly structured lessons in advanced reading, writing, and mathematics. Expert guidance from 99+ ATAR tutors with exam-style practice.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }

    /**
     * Seed testimonials from Ace Academics students.
     */
    private function seedTestimonials(): void
    {
        $testimonials = [
            [
                'name' => 'Sarah M.',
                'designation' => 'Year 12 Student — ATAR 99.80',
                'rating' => 5,
                'profile_image' => '',
                'comments' => 'Ace Academics changed the way I approached studying. The structure, feedback, and support helped me go from average marks to ranking among the top of my grade. I could not have achieved my ATAR without them.',
                'status' => 1,
            ],
            [
                'name' => 'James K.',
                'designation' => 'Medicine Student — University of Queensland',
                'rating' => 5,
                'profile_image' => '',
                'comments' => 'Before joining Ace, I was not confident about entrance into medicine. The tutors believed in me more than I believed in myself, and that made all the difference. Their UCAT prep and interview coaching were exceptional.',
                'status' => 1,
            ],
            [
                'name' => 'Priya R.',
                'designation' => 'Parent — Selective School Entry',
                'rating' => 5,
                'profile_image' => '',
                'comments' => 'My daughter secured a place at Brisbane State High School after just six months with Ace Academics. The tutors identified her weak areas and built a personalised plan. We are so grateful for the structured approach and genuine care.',
                'status' => 1,
            ],
            [
                'name' => 'Daniel T.',
                'designation' => 'Year 11 Student — Top 5 in Methods',
                'rating' => 5,
                'profile_image' => '',
                'comments' => 'The tutors at Ace Academics are not just smart — they know how to teach. My Methods tutor broke down complex topics into simple steps and always made time for extra questions. My confidence in maths has completely transformed.',
                'status' => 1,
            ],
            [
                'name' => 'Emily W.',
                'designation' => 'Scholarship Recipient — Grammar School',
                'rating' => 5,
                'profile_image' => '',
                'comments' => 'I received a full academic scholarship after preparing with Ace Academics. The practice exams, timed conditions, and detailed feedback gave me the edge I needed on exam day. Highly recommend to anyone aiming for scholarships.',
                'status' => 1,
            ],
            [
                'name' => 'Michael C.',
                'designation' => 'Parent — NAPLAN Year 5',
                'rating' => 5,
                'profile_image' => '',
                'comments' => 'Our son went from Band 5 to Band 9 in NAPLAN numeracy after working with Ace Academics. The tutors made learning enjoyable and my son actually looks forward to his sessions now. The results speak for themselves.',
                'status' => 1,
            ],
        ];

        Testimonial::truncate();

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }

    /**
     * Seed FAQs for Ace Academics.
     */
    private function seedFaqs(): void
    {
        $faqs = [
            [
                'title' => 'What subjects does Ace Academics offer tutoring in?',
                'answer' => 'We offer tutoring across a wide range of subjects including Mathematics (General, Methods, Specialist), English, Chemistry, Physics, Biology, and Economics. We also provide specialised preparation for Selective School entry exams, NAPLAN, Scholarship exams, UCAT, and all ATAR subjects for Year 11 and 12 students.',
            ],
            [
                'title' => 'Who are your tutors?',
                'answer' => 'All Ace Academics tutors are high-achieving graduates and university students who scored in the top percentiles of their cohort. Our lead tutor achieved an ATAR of 99.95 and received the QCE Distinguished Student Award. Most tutors are studying or have completed degrees in Medicine, Engineering, or Finance at leading Australian universities. Every tutor is carefully selected for both academic excellence and teaching ability.',
            ],
            [
                'title' => 'Do you offer online or in-person tutoring?',
                'answer' => 'We offer both online and in-person tutoring options. Our online sessions use interactive tools that make learning just as effective as face-to-face. In-person sessions are available in the Brisbane metropolitan area. Both formats include access to our learning resources and practice materials.',
            ],
            [
                'title' => 'How are tutoring sessions structured?',
                'answer' => 'Each session is structured around the student\'s individual learning goals. Sessions typically include a review of previous material, introduction of new concepts with worked examples, guided practice problems, and targeted exam-style questions. Students receive detailed feedback and personalised homework between sessions.',
            ],
            [
                'title' => 'What year levels do you cater for?',
                'answer' => 'We cater to students from Year 3 through to Year 12, as well as students preparing for university entrance exams like the UCAT. Our programs are tailored to each year level, from NAPLAN preparation in primary school to intensive ATAR coaching in senior secondary.',
            ],
            [
                'title' => 'How much does tutoring cost?',
                'answer' => 'Our pricing varies depending on the subject, year level, and whether sessions are individual or small group. We offer flexible packages to suit different needs and budgets. Please contact us at admin@aceacademic.com.au for a detailed quote tailored to your requirements.',
            ],
            [
                'title' => 'How do I enrol my child?',
                'answer' => 'Getting started is easy. Simply register on our platform, browse our available programs, and select the one that best suits your child\'s needs. You can also contact us directly at admin@aceacademic.com.au for a free consultation where we assess your child\'s current level and recommend the best learning pathway.',
            ],
            [
                'title' => 'What results have your students achieved?',
                'answer' => 'Our students consistently achieve outstanding results. Many have gained entry into leading selective schools, received academic scholarships, and secured places in highly competitive university courses including Medicine and Engineering. Our tutors have a proven track record of helping students achieve ATAR scores above 99 and UCAT scores above 3300.',
            ],
            [
                'title' => 'Do you offer a free trial session?',
                'answer' => 'Yes, we offer an initial consultation and assessment session so you can experience our teaching approach first-hand. This allows us to understand your child\'s strengths and areas for improvement, and helps you decide if Ace Academics is the right fit.',
            ],
            [
                'title' => 'Can I track my child\'s progress?',
                'answer' => 'Absolutely. Parents and students have access to our online platform where you can track session attendance, view tutor feedback, monitor progress on practice assessments, and see improvement over time. We also provide regular progress reports and are always available for parent consultations.',
            ],
        ];

        Faq::truncate();

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }

    /**
     * Seed pages — About Us, Programs, Online Platform, Free Resources, Workshop,
     * Privacy Policy, Terms & Conditions, Refund Policy.
     */
    private function seedPages(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'url' => 'about-us',
                'content' => '<div>
                    <h2><b><span style="font-size:24px;">WHO WE ARE</span></b></h2>
                    <div><br></div>
                    <div style="font-size:18px;">Meet the mentors behind Ace Academics.</div>
                    <div><br></div>
                    <div>We combine proven academic results with structured teaching, mentorship, and real exam insight — helping students build confidence, perform under pressure, and achieve meaningful outcomes.</div>
                    <div><br></div>

                    <h3><b><span style="font-size:20px;">Lead Tutor — Aditya Anand | 99.95 ATAR</span></b></h3>
                    <div><br></div>
                    <div><b>Founder · Lead Tutor · 2000+ hours of tutoring experience</b></div>
                    <div><br></div>
                    <div>Aditya founded Ace Academics with a simple belief: that with the right structure, guidance, and effort, every student can perform at a level they once thought was beyond them.</div>
                    <div><br></div>
                    <div>A graduate of Brisbane State High School, Aditya achieved an ATAR of 99.95 and was recognised with the QCE Distinguished Student Award. He received acceptance into medicine across universities in Australia and is a recipient of multiple scholarships.</div>
                    <div><br></div>
                    <div>With over 2000 hours of tutoring experience, Aditya has worked with students across a wide range of abilities — from those aiming to pass, to those targeting 99+ ATARs and selective school entry. His teaching approach focuses on building systems, not shortcuts: structured study plans, exam technique, and consistent mentorship that helps students take ownership of their learning.</div>
                    <div><br></div>
                    <div>Beyond academics, Aditya brings practical insight into the pressures students face — balancing school, exams, and expectations — and designs programs that support long-term performance, not just last-minute cramming.</div>
                    <div><br></div>

                    <h3><b><span style="font-size:20px;">Senior Tutor — Prabhas Bachu | 99.00 ATAR</span></b></h3>
                    <div><br></div>
                    <div><b>Senior Tutor · Finance & Economics at UQ</b></div>
                    <div><br></div>
                    <div>Prabhas is currently completing his Bachelor of Advanced Finance and Economics (Honours) at the University of Queensland. He achieved an ATAR of 99.00 and brings both academic depth and a genuine passion for teaching.</div>
                    <div><br></div>
                    <div>As a Senior Tutor at Ace Academics, Prabhas works closely with students on mathematics, economics, and exam preparation. His teaching style is structured, patient, and focused on helping students develop real understanding — not just memorised answers.</div>
                    <div><br></div>

                    <div style="font-style:italic; border-left: 4px solid #333; padding-left: 16px; margin: 20px 0;">"Our tutors are selected not only for their academic achievements, but for their ability to teach clearly, motivate consistently, and genuinely care about student progress."</div>
                    <div><br></div>

                    <h3><b><span style="font-size:18px;">Get in Touch</span></b></h3>
                    <div><br></div>
                    <div>Interested in working together? Fill out some info and we will be in touch shortly.</div>
                    <div>Email: <a href="mailto:admin@aceacademic.com.au">admin@aceacademic.com.au</a></div>
                </div>',
            ],
            [
                'title' => 'Programs',
                'url' => 'programs',
                'content' => '<div>
                    <h2><b><span style="font-size:24px;">High-Achieving Programs for all types of students</span></b></h2>
                    <div><br></div>

                    <h3><b><span style="font-size:20px;">Acceleration Class</span></b></h3>
                    <div><br></div>
                    <div>Accelerates students beyond the school curriculum. Online video platform for content. Extensive weekly homework.</div>
                    <div><br></div>

                    <h3><b><span style="font-size:20px;">UCAT Excellence</span></b></h3>
                    <div><br></div>
                    <div>On-demand UCAT video lessons covering all sections. Strategy-focused teaching with worked examples and exam techniques. Self-paced learning with clear skill progression and structure.</div>
                    <div><br></div>

                    <h3><b><span style="font-size:20px;">Selective Exam Preparation</span></b></h3>
                    <div><br></div>
                    <div>Targeted prep for Queensland and NSW selective school and NAPLAN exams. Weekly structured lessons in advanced reading, writing, and mathematics. Expert guidance from 99+ ATAR tutors with exam-style practice.</div>
                </div>',
            ],
            [
                'title' => 'Online Platform',
                'url' => 'online-platform',
                'content' => '<div>
                    <div style="background: #f0f0f0; display: inline-block; padding: 4px 12px; border-radius: 4px; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">EXCLUSIVE MEMBER ACCESS</div>
                    <div><br></div>
                    <h2><b><span style="font-size:24px;">Access the online platform</span></b></h2>
                    <div><br></div>
                    <div>Unlock the private Ace Academics member portal with structured video lessons, premium resources, guided practice, and exclusive support for enrolled students.</div>
                    <div><br></div>
                    <div><b>INCLUDED:</b> Video lessons, guided resources, and exam-focused support</div>
                    <div><b>ACCESS:</b> Available for Ace members and enrolled students only</div>
                    <div><br></div>
                    <div><a href="/login">Access Online Platform</a> | <a href="/contact">Request Access</a></div>
                    <div><br></div>
                    <div><em>Already enrolled but having trouble accessing the portal? Contact Ace directly for support.</em></div>
                </div>',
            ],
            [
                'title' => 'Free Resources',
                'url' => 'free-resources',
                'content' => '<div>
                    <h2><b><span style="font-size:24px;">Try our Free Resources</span></b></h2>
                    <div><br></div>

                    <h3><b><span style="font-size:20px;">Parent Guide: How to best support your child.</span></b></h3>
                    <div>Practical strategies, insights, and resources for academic growth and emotional well-being.</div>
                    <div><br></div>

                    <h3><b><span style="font-size:20px;">Essay Plan: How to write the perfect essay</span></b></h3>
                    <div>Step-by-step framework for writing the perfect essay.</div>
                    <div><br></div>

                    <h3><b><span style="font-size:20px;">Selective Exam Readiness Checklist</span></b></h3>
                    <div>Helps parents assess how prepared their child is for selective entry or scholarship exams.</div>
                </div>',
            ],
            [
                'title' => 'Workshop',
                'url' => 'workshop',
                'content' => '<div>
                    <h2><b><span style="font-size:24px;">Academic Performance Workshops</span></b></h2>
                    <div><br></div>

                    <h3><b><span style="font-size:20px;">Module 1: Study System Design</span></b></h3>
                    <div>Build a personalised study system that works. Learn how to structure your week, prioritise tasks, and create habits that support long-term academic performance.</div>
                    <div><br></div>

                    <h3><b><span style="font-size:20px;">Module 2: Avoiding Senior Mistakes</span></b></h3>
                    <div>Understand the most common mistakes senior students make — from poor time management to ineffective revision — and learn how to avoid them before they cost you marks.</div>
                    <div><br></div>

                    <h3><b><span style="font-size:20px;">Module 3: Subject & Degree Strategy</span></b></h3>
                    <div>Make informed decisions about subject selection and degree pathways. Align your choices with your strengths, interests, and long-term goals.</div>
                    <div><br></div>

                    <h3><b><span style="font-size:20px;">Module 4: Exam Preparation Framework</span></b></h3>
                    <div>Master a proven framework for exam preparation — including active recall, spaced repetition, and exam-day strategies that maximise your performance under pressure.</div>
                    <div><br></div>

                    <h3><b><span style="font-size:18px;">Workshop Details</span></b></h3>
                    <div><br></div>
                    <div><b>Format:</b> 90 minutes | Presentation + Frameworks + Discussion</div>
                    <div><b>Audience:</b> Years 11–12</div>
                    <div><br></div>

                    <h3><b><span style="font-size:18px;">Post-Workshop Resources</span></b></h3>
                    <div><br></div>
                    <div>Every attendee receives:</div>
                    <ul>
                        <li>Planning template</li>
                        <li>Exam checklist</li>
                        <li>Active recall guide</li>
                        <li>Framework summary</li>
                    </ul>
                </div>',
            ],
            [
                'title' => 'Privacy Policy',
                'url' => 'privacy-policy',
                'content' => '<div><h2><b><span style="font-size:24px;">Privacy Policy</span></b></h2><div><br></div><div>Ace Academics is committed to protecting your privacy and ensuring a safe online experience. This Privacy Policy explains how we collect, use, and safeguard your personal information when you visit or use our website. By using our website, you agree to the terms of this Privacy Policy.</div><div><br></div><h3><b><span style="font-size:18px;">1. Information We Collect</span></b></h3><div><br></div><div>When you create an account, enrol in a course, or interact with our services, we may collect the following personal information: name, email address, phone number, billing address, payment information (processed through secure third-party payment providers), student year level and academic details, and profile information.</div><div><br></div><div>We may also collect non-personal information including IP address, browser type, device information, and usage data such as pages visited and time spent on the platform.</div><div><br></div><h3><b><span style="font-size:18px;">2. How We Use Your Information</span></b></h3><div><br></div><div>We use your information for account management, course access and progress tracking, communication about sessions and updates, payment processing through secure third-party processors, analytics to improve our platform, and compliance with applicable Australian laws and regulations.</div><div><br></div><h3><b><span style="font-size:18px;">3. Data Protection</span></b></h3><div><br></div><div>We implement industry-standard security measures including encryption and secure server practices to protect your personal data. We comply with the Australian Privacy Act 1988 and the Australian Privacy Principles (APPs).</div><div><br></div><h3><b><span style="font-size:18px;">4. Your Rights</span></b></h3><div><br></div><div>You have the right to access, correct, and request deletion of your personal information. You can opt out of promotional communications at any time. For any privacy-related inquiries, please contact us at admin@aceacademic.com.au.</div></div>',
            ],
            [
                'title' => 'Terms & Conditions',
                'url' => 'terms-conditions',
                'content' => '<div><h2><b><span style="font-size:24px;">Terms and Conditions</span></b></h2><div><br></div><div>Welcome to Ace Academics. These Terms and Conditions govern your access to and use of the Ace Academics website and learning platform, including all content, services, and features offered through the platform. By accessing or using the website, you agree to comply with and be bound by these Terms.</div><div><br></div><h3><b><span style="font-size:18px;">1. Eligibility</span></b></h3><div><br></div><div>Students of all ages may use our platform. For students under 18, a parent or guardian must create and manage the account and consent to these terms on behalf of the student.</div><div><br></div><h3><b><span style="font-size:18px;">2. Account Registration</span></b></h3><div><br></div><div>To access our tutoring services, you must create an account with accurate and current information. You are responsible for maintaining the confidentiality of your account credentials and for all activities under your account.</div><div><br></div><h3><b><span style="font-size:18px;">3. Course Access and Use</span></b></h3><div><br></div><div>Access to courses and materials is subject to enrolment and payment. Course content is for personal educational use only and may not be reproduced, distributed, or shared without written consent from Ace Academics. We reserve the right to update or modify course content at any time.</div><div><br></div><h3><b><span style="font-size:18px;">4. Payment and Refund Policy</span></b></h3><div><br></div><div>Fees are payable upon enrolment. Payments are processed through secure third-party payment providers. Refund requests must be submitted within 7 days of purchase. Refunds will be assessed on a case-by-case basis. No refunds will be issued for sessions already attended.</div><div><br></div><h3><b><span style="font-size:18px;">5. Intellectual Property</span></b></h3><div><br></div><div>All content on the Ace Academics platform, including course materials, videos, practice papers, and assessments, is the intellectual property of Ace Academics and is protected by Australian copyright law.</div><div><br></div><h3><b><span style="font-size:18px;">6. Governing Law</span></b></h3><div><br></div><div>These Terms are governed by the laws of Queensland, Australia. Any disputes shall be resolved in the courts of Queensland.</div><div><br></div><h3><b><span style="font-size:18px;">7. Contact</span></b></h3><div><br></div><div>For questions about these Terms, please contact us at admin@aceacademic.com.au.</div></div>',
            ],
            [
                'title' => 'Refund Policy',
                'url' => 'refund-policy',
                'content' => '<div><h2><b><span style="font-size:24px;">Refund Policy</span></b></h2><div><br></div><div>At Ace Academics, we are committed to providing high-quality tutoring services. We understand that circumstances may change, and we want to ensure a fair refund process for our students and families.</div><div><br></div><h3><b><span style="font-size:18px;">Eligibility for Refunds</span></b></h3><div><br></div><div>Refund requests must be submitted within 7 days of the original purchase date. Refunds will only be considered for sessions that have not yet been attended. If you have attended any sessions within a package, a pro-rata refund may be offered for the remaining unused sessions at our discretion.</div><div><br></div><h3><b><span style="font-size:18px;">How to Request a Refund</span></b></h3><div><br></div><div>To request a refund, please contact us at admin@aceacademic.com.au with your full name, the course or package purchased, reason for the refund request, and your preferred refund method. We will review your request and respond within 5 business days.</div><div><br></div><h3><b><span style="font-size:18px;">Non-Refundable Items</span></b></h3><div><br></div><div>The following are not eligible for refunds: sessions already attended, downloadable resources that have been accessed, custom assessment reports that have been delivered, and any promotional or discounted packages marked as non-refundable at the time of purchase.</div><div><br></div><h3><b><span style="font-size:18px;">Processing Time</span></b></h3><div><br></div><div>Approved refunds will be processed within 10 business days. Refunds will be issued to the original payment method used at the time of purchase.</div></div>',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['url' => $page['url']], $page);
        }
    }

    /**
     * Seed theme settings for Ace Academics branding.
     * Footer, social links, counters — matching old site.
     */
    private function seedThemeSettings(): void
    {
        // Footer top settings — matching old site nav: Home, Programs, About, Online Platform, Free Resources, Workshop, Contact
        $footerTop = [
            'one_status' => 'on',
            'one_title' => 'Ace Academic Coaching — Helping students build confidence, achieve top results, and perform when it matters most.',
            'one_social_menu' => 'on',
            'two_status' => 'on',
            'two_title' => 'Quick Links',
            'two_menu' => '<ul><li><a href="/">Home</a></li><li><a href="/page/programs">Programs</a></li><li><a href="/page/about-us">About</a></li><li><a href="/page/online-platform">Online Platform</a></li><li><a href="/page/free-resources">Free Resources</a></li><li><a href="/page/workshop">Workshop</a></li><li><a href="/contact">Contact</a></li></ul>',
            'three_status' => 'on',
            'three_title' => 'Programs',
            'three_menu' => '<ul><li><a href="/category/acceleration-class">Acceleration Class</a></li><li><a href="/category/ucat-excellence">UCAT Excellence</a></li><li><a href="/category/selective-exam-preparation">Selective Exam Preparation</a></li></ul>',
            'five_status' => 'on',
            'five_title' => 'Subscribe to Our Newsletter',
        ];

        // Footer bottom settings
        $footerBottom = [
            'status' => 'on',
            'copy_right' => '&copy; ' . date('Y') . ' Ace Academic Coaching. All Rights Reserved.',
            'menu' => '<a href="/page/privacy-policy">Privacy Policy</a><a href="/page/terms-conditions">Terms & Conditions</a><a href="/page/refund-policy">Refund Policy</a>',
        ];

        // Social media links — icon must be full HTML <i> tag, not just class name
        $socials = [
            [
                'name' => 'Facebook',
                'icon' => '<i class="ri-facebook-fill"></i>',
                'url' => 'https://www.facebook.com/aceacademicsau',
            ],
            [
                'name' => 'Instagram',
                'icon' => '<i class="ri-instagram-fill"></i>',
                'url' => 'https://www.instagram.com/aceacademicsau',
            ],
            [
                'name' => 'LinkedIn',
                'icon' => '<i class="ri-linkedin-fill"></i>',
                'url' => 'https://www.linkedin.com/company/ace-academics',
            ],
        ];

        // Counter settings
        $counter = [
            'total_experience' => 5,
        ];

        // General settings (top bar email, phone, address, office hours)
        $general = [
            'email' => 'admin@aceacademic.com.au',
            'phone' => '0412345678',
            'address' => 'Brisbane, Queensland, Australia',
            'second_email' => '',
            'second_phone' => '',
            'office_hours' => '9AM-6PM',
            'support_hours' => '24/7',
            'is_multiple_theme' => '',
        ];

        // Backend general settings
        $backendGeneral = [
            'footer_show_bottom' => '1',
            'footer_copyright' => '&copy; ' . date('Y') . ' Ace Academic Coaching. All Rights Reserved.',
            'footer_menu' => '<a href="/page/privacy-policy">Privacy Policy</a><a href="/page/terms-conditions">Terms & Conditions</a><a href="/page/refund-policy">Refund Policy</a>',
            'site_name' => 'Ace Academics',
            'site_description' => 'Helping students build confidence, achieve top results, and perform when it matters most. Expert tutoring in Brisbane — Selective, NAPLAN, ATAR & UCAT Preparation.',
            'site_keywords' => 'tutoring, Brisbane, ATAR, NAPLAN, selective school, scholarship, UCAT, medicine, Queensland, Ace Academics, academic excellence, Ace Academic Coaching',
            'app_name' => 'Ace Academics',
            'contact_email' => 'admin@aceacademic.com.au',
        ];

        // Store theme settings
        $settings = [
            'general' => $general,
            'footer_topen' => $footerTop,
            'footer_bottomen' => $footerBottom,
            'social' => ['socials' => $socials],
            'counter' => $counter,
            'backend_general' => $backendGeneral,
        ];

        foreach ($settings as $key => $content) {
            ThemeSetting::updateOrCreate(
                ['key' => $key],
                [
                    'key' => $key,
                    'content' => $content,
                ]
            );
        }
    }

    /**
     * Seed year levels.
     */
    private function seedLevels(): void
    {
        $levels = [
            'Year 3-4',
            'Year 5-6',
            'Year 7-8',
            'Year 9-10',
            'Year 11',
            'Year 12',
            'University Entrance',
        ];

        foreach ($levels as $name) {
            Level::updateOrCreate(['name' => $name], ['name' => $name]);
        }
    }

    /**
     * Seed subjects.
     */
    private function seedSubjects(): void
    {
        $subjects = [
            'Mathematical Methods',
            'Specialist Mathematics',
            'General Mathematics',
            'Chemistry',
            'Physics',
            'Biology',
            'English',
            'Economics',
            'Reasoning & Problem Solving',
            'Reading Comprehension',
            'Writing',
            'Numeracy',
        ];

        foreach ($subjects as $name) {
            Subject::updateOrCreate(['name' => $name], ['name' => $name]);
        }
    }

    /**
     * Seed instructor/tutor profiles — matching old site exactly.
     * Homepage shows: Aditya A. (99.95), Adwitiya G. (99.96), Ishaan T. (99.90),
     * Suhani G. (UCAT 3380), Turhan A. (99.85), Dinidu R. (99.65),
     * Devraj D. (UCAT 3330), Aditya N. (99.65), Rohith P. (99.65)
     * About page adds: Prabhas Bachu (99.00)
     */
    private function seedInstructors(): void
    {
        $tutors = [
            [
                'first_name' => 'Aditya',
                'last_name' => 'Anand',
                'email' => 'aditya@aceacademic.com.au',
                'phone' => '0400000001',
                'about' => 'Founder and Lead Tutor at Ace Academics with over 2000 hours of tutoring experience. Achieved an ATAR of 99.95 at Brisbane State High School and was recognised with the QCE Distinguished Student Award. Received acceptance into medicine across universities in Australia and is a recipient of multiple scholarships. Aditya has worked with students across a wide range of abilities — from those aiming to pass, to those targeting 99+ ATARs and selective school entry. His teaching approach focuses on building systems, not shortcuts: structured study plans, exam technique, and consistent mentorship that helps students take ownership of their learning. Beyond academics, Aditya brings practical insight into the pressures students face — balancing school, exams, and expectations — and designs programs that support long-term performance, not just last-minute cramming.',
            ],
            [
                'first_name' => 'Prabhas',
                'last_name' => 'Bachu',
                'email' => 'prabhas@aceacademic.com.au',
                'phone' => '0400000010',
                'about' => 'Senior Tutor at Ace Academics. Achieved an ATAR of 99.00 and is currently completing his Bachelor of Advanced Finance and Economics (Honours) at the University of Queensland. As a Senior Tutor, Prabhas works closely with students on mathematics, economics, and exam preparation. His teaching style is structured, patient, and focused on helping students develop real understanding — not just memorised answers.',
            ],
            [
                'first_name' => 'Adwitiya',
                'last_name' => 'G.',
                'email' => 'adwitiya@aceacademic.com.au',
                'phone' => '0400000002',
                'about' => 'Achieved an ATAR of 99.96 and is studying Medicine at the University of Queensland. Adwitiya is known for breaking down complex science concepts into clear, understandable steps. Specialises in Chemistry, Physics, and Biology.',
            ],
            [
                'first_name' => 'Ishaan',
                'last_name' => 'T.',
                'email' => 'ishaan@aceacademic.com.au',
                'phone' => '0400000003',
                'about' => 'Achieved an ATAR of 99.90 and is studying Medicine at the University of Queensland. Ishaan excels at identifying student learning gaps and building targeted improvement plans. Specialises in Mathematical Methods, Specialist Mathematics, and Physics.',
            ],
            [
                'first_name' => 'Suhani',
                'last_name' => 'G.',
                'email' => 'suhani@aceacademic.com.au',
                'phone' => '0400000004',
                'about' => 'Achieved a UCAT score of 3380 and is studying Medicine at the University of Queensland. Suhani specialises in UCAT preparation, English, and interview coaching. Her structured approach to exam technique has helped many students secure medicine offers.',
            ],
            [
                'first_name' => 'Turhan',
                'last_name' => 'A.',
                'email' => 'turhan@aceacademic.com.au',
                'phone' => '0400000005',
                'about' => 'Achieved an ATAR of 99.85 and is studying Medicine at Griffith University. Turhan brings energy and enthusiasm to every session. Specialises in Chemistry, Biology, and Selective School preparation.',
            ],
            [
                'first_name' => 'Dinidu',
                'last_name' => 'R.',
                'email' => 'dinidu@aceacademic.com.au',
                'phone' => '0400000006',
                'about' => 'Achieved an ATAR of 99.65 with outstanding results across multiple subjects. Dinidu is an experienced tutor who focuses on building student confidence alongside academic skills. Specialises in Mathematics, Economics, and ATAR exam technique.',
            ],
            [
                'first_name' => 'Devraj',
                'last_name' => 'D.',
                'email' => 'devraj@aceacademic.com.au',
                'phone' => '0400000007',
                'about' => 'Achieved a UCAT score of 3330 and is studying Medicine at the University of Queensland. Devraj specialises in UCAT preparation and Science subjects. His methodical approach to problem-solving helps students develop strong analytical skills.',
            ],
            [
                'first_name' => 'Aditya',
                'last_name' => 'N.',
                'email' => 'adityan@aceacademic.com.au',
                'phone' => '0400000008',
                'about' => 'Achieved an ATAR of 99.65 and is studying Medicine at the University of Queensland. Aditya N. is known for his patient teaching style and ability to explain difficult topics clearly. Specialises in Chemistry, Physics, and NAPLAN preparation.',
            ],
            [
                'first_name' => 'Rohith',
                'last_name' => 'P.',
                'email' => 'rohith@aceacademic.com.au',
                'phone' => '0400000009',
                'about' => 'Achieved an ATAR of 99.65 and is studying a Bachelor of Advanced Finance and Economics (BAFE) at the University of Queensland. Rohith specialises in Mathematics, Economics, and English. His real-world approach to teaching makes learning engaging and relevant.',
            ],
        ];

        foreach ($tutors as $tutor) {
            $instructor = Instructor::updateOrCreate(
                ['first_name' => $tutor['first_name'], 'last_name' => $tutor['last_name']],
                [
                    'first_name' => $tutor['first_name'],
                    'last_name' => $tutor['last_name'],
                    'phone' => $tutor['phone'],
                    'about' => $tutor['about'],
                    'status' => 1,
                ]
            );

            User::updateOrCreate(
                ['email' => $tutor['email']],
                [
                    'userable_type' => 'Modules\\LMS\\Models\\Auth\\Instructor',
                    'userable_id' => $instructor->id,
                    'guard' => 'web',
                    'username' => Str::slug($tutor['first_name'] . '-' . $tutor['last_name']),
                    'email' => $tutor['email'],
                    'password' => Hash::make('AceAcademics2024!'),
                    'is_verify' => 1,
                ]
            );
        }
    }
}
