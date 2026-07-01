<?php
function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function current_page(): string
{
    return basename($_SERVER['SCRIPT_NAME']);
}

function is_active(string $page): string
{
    return current_page() === $page ? 'active' : '';
}

function countries(): array
{
    return [
        'Afghanistan','Albania','Algeria','Andorra','Angola','Antigua and Barbuda','Argentina','Armenia','Australia','Austria','Azerbaijan',
        'Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan','Bolivia','Bosnia and Herzegovina','Botswana','Brazil','Brunei','Bulgaria','Burkina Faso','Burundi',
        'Cabo Verde','Cambodia','Cameroon','Canada','Central African Republic','Chad','Chile','China','Colombia','Comoros','Congo','Costa Rica','Croatia','Cuba','Cyprus','Czech Republic',
        'Democratic Republic of the Congo','Denmark','Djibouti','Dominica','Dominican Republic','Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Eswatini','Ethiopia',
        'Fiji','Finland','France','Gabon','Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala','Guinea','Guinea-Bissau','Guyana',
        'Haiti','Honduras','Hungary','Iceland','India','Indonesia','Iran','Iraq','Ireland','Israel','Italy','Ivory Coast','Jamaica','Japan','Jordan',
        'Kazakhstan','Kenya','Kiribati','Kuwait','Kyrgyzstan','Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg',
        'Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico','Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar',
        'Namibia','Nauru','Nepal','Netherlands','New Zealand','Nicaragua','Niger','Nigeria','North Korea','North Macedonia','Norway','Oman',
        'Pakistan','Palau','Palestine','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal','Qatar',
        'Romania','Russia','Rwanda','Saint Kitts and Nevis','Saint Lucia','Saint Vincent and the Grenadines','Samoa','San Marino','Sao Tome and Principe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','South Korea','South Sudan','Spain','Sri Lanka','Sudan','Suriname','Sweden','Switzerland','Syria',
        'Taiwan','Tajikistan','Tanzania','Thailand','Timor-Leste','Togo','Tonga','Trinidad and Tobago','Tunisia','Turkey','Turkmenistan','Tuvalu',
        'Uganda','Ukraine','United Arab Emirates','United Kingdom','United States','Uruguay','Uzbekistan','Vanuatu','Vatican City','Venezuela','Vietnam','Yemen','Zambia','Zimbabwe'
    ];
}

function services(): array
{
    return [
        [
            'id' => 'virtual-assistant',
            'title' => 'AI Virtual Assistant Solutions',
            'category' => 'AI',
            'image' => 'assets/img/service-assistant.svg',
            'summary' => 'Interactive assistants that answer customer questions and support enquiries 24/7.',
            'details' => 'AI-Solutions designs virtual assistant prototypes that can answer frequently asked questions, capture customer requirements, route enquiries and support digital employee experience. The solution helps businesses reply faster without forcing customers to create accounts.',
            'benefits' => ['24/7 customer support', 'Faster enquiry handling', 'Reduced manual response workload', 'Better customer experience'],
            'technologies' => ['PHP', 'JavaScript', 'MySQL', 'FAQ Logic']
        ],
        [
            'id' => 'business-automation',
            'title' => 'Business Automation Systems',
            'category' => 'Automation',
            'image' => 'assets/img/service-automation.svg',
            'summary' => 'Workflow automation systems for approvals, tasks, notifications and record tracking.',
            'details' => 'This service focuses on replacing repetitive manual processes with structured online workflows. It can support internal request tracking, form approvals, customer follow-up and simple reporting for management.',
            'benefits' => ['Less repetitive administration', 'Clearer task tracking', 'Improved staff productivity', 'Consistent data records'],
            'technologies' => ['PHP', 'MySQL', 'JavaScript', 'Bootstrap-style CSS']
        ],
        [
            'id' => 'ai-prototyping',
            'title' => 'AI Prototyping Solutions',
            'category' => 'AI',
            'image' => 'assets/img/service-prototype.svg',
            'summary' => 'Affordable proof-of-concept prototypes for companies testing AI ideas.',
            'details' => 'AI-Solutions creates early prototypes so clients can test ideas before investing heavily. The prototype can include forms, dashboards, AI logic mock-ups, data capture and demonstration flows.',
            'benefits' => ['Quick validation of ideas', 'Lower development risk', 'Clear demo for stakeholders', 'Better planning before full build'],
            'technologies' => ['Rapid Prototyping', 'PHP', 'MySQL', 'JavaScript']
        ],
        [
            'id' => 'data-dashboard',
            'title' => 'Data Dashboard and Analytics',
            'category' => 'Analytics',
            'image' => 'assets/img/service-dashboard.svg',
            'summary' => 'Dashboards that show customer enquiries, registrations, ratings and activity trends.',
            'details' => 'Dashboards help managers understand business performance by showing enquiry counts, review ratings, event registrations and customer demand in a simple interface.',
            'benefits' => ['Better management decisions', 'Clear KPI monitoring', 'Trend visibility', 'Faster reporting'],
            'technologies' => ['MySQL', 'Chart.js-style UI', 'PHP', 'Data Tables']
        ],
        [
            'id' => 'support-automation',
            'title' => 'Customer Support Automation',
            'category' => 'Automation',
            'image' => 'assets/img/service-support.svg',
            'summary' => 'Automated support flows for FAQs, ticket capture and customer follow-up.',
            'details' => 'This solution collects customer issues, validates required details and helps the company prioritise support enquiries. It supports simple ticket-style workflows through the admin dashboard.',
            'benefits' => ['Organised customer support', 'Better response history', 'Reduced lost enquiries', 'Improved satisfaction'],
            'technologies' => ['PHP Sessions', 'MySQL', 'Validation Rules', 'Admin Dashboard']
        ],
        [
            'id' => 'web-ai-software',
            'title' => 'Web-Based AI Software Solutions',
            'category' => 'Web Software',
            'image' => 'assets/img/service-webai.svg',
            'summary' => 'Responsive web systems that combine customer forms, content and admin controls.',
            'details' => 'AI-Solutions builds responsive browser-based systems that work across desktop, tablet and mobile screens. The systems include secure admin areas, validated forms and content sections.',
            'benefits' => ['Responsive user experience', 'Centralised data', 'Secure admin access', 'Scalable web presence'],
            'technologies' => ['HTML5', 'CSS3', 'JavaScript', 'PHP', 'MySQL']
        ],
    ];
}

function projects(): array
{
    return [
        ['id'=>'retail-assistant','title'=>'Retail Helpdesk Assistant','category'=>'AI','image'=>'assets/img/project-retail.svg','rating'=>4.8,'reviews'=>28,'summary'=>'An AI assistant prototype that answers retail customer queries and records product support requests.','client'=>'North East Retail Group'],
        ['id'=>'hr-portal','title'=>'HR Onboarding Portal','category'=>'Automation','image'=>'assets/img/project-hr.svg','rating'=>4.6,'reviews'=>19,'summary'=>'A workflow portal that guides new employees through onboarding tasks and document submission.','client'=>'Workforce Connect'],
        ['id'=>'operations-dashboard','title'=>'Operations Analytics Dashboard','category'=>'Analytics','image'=>'assets/img/project-analytics.svg','rating'=>4.9,'reviews'=>35,'summary'=>'A management dashboard showing enquiries, registrations, review ratings and monthly activity trends.','client'=>'Sunderland Services Hub'],
        ['id'=>'health-booking','title'=>'Healthcare Booking Assistant','category'=>'AI','image'=>'assets/img/project-health.svg','rating'=>4.7,'reviews'=>22,'summary'=>'A prototype assistant that helps patients request appointment support and sends details to the admin team.','client'=>'Community Care Clinic'],
        ['id'=>'student-query','title'=>'Student Query Support Bot','category'=>'Education','image'=>'assets/img/project-education.svg','rating'=>4.5,'reviews'=>16,'summary'=>'A web-based assistant that helps students find common answers and submit course enquiries.','client'=>'Learning Support Centre'],
        ['id'=>'logistics-tracker','title'=>'Logistics Tracking Dashboard','category'=>'Web Software','image'=>'assets/img/project-logistics.svg','rating'=>4.4,'reviews'=>13,'summary'=>'A tracking dashboard prototype that helps staff view delivery statuses and contact records.','client'=>'Rapid Logistics Ltd']
    ];
}

function articles(): array
{
    return [
        ['id'=>1,'title'=>'How AI Virtual Assistants Improve Customer Response Time','category'=>'AI','date'=>'2026-05-08','image'=>'assets/img/article-ai.svg','summary'=>'A practical article explaining how virtual assistants help businesses answer customer questions faster.','body'=>'AI virtual assistants support businesses by giving customers immediate responses to common questions. They also capture structured enquiry data so staff can follow up with the right information. For a start-up like AI-Solutions, this creates a strong digital presence and shows the company can use AI to improve the employee and customer experience.'],
        ['id'=>2,'title'=>'Why Small Businesses Need Workflow Automation','category'=>'Automation','date'=>'2026-05-15','image'=>'assets/img/article-support.svg','summary'=>'This article highlights how automation reduces repetitive administration and improves service quality.','body'=>'Workflow automation helps small businesses reduce repeated manual tasks. Online forms, status updates and dashboards make it easier to manage enquiries and customer requests. Automation is also useful for student projects because it can be demonstrated clearly through forms, database records and admin pages.'],
        ['id'=>3,'title'=>'Using Prototypes to Test AI Ideas Before Full Development','category'=>'Prototyping','date'=>'2026-05-24','image'=>'assets/img/article-prototype.svg','summary'=>'A guide to using prototypes to test AI product ideas before committing to a full system.','body'=>'A prototype allows a business to test whether a proposed AI solution is useful before full investment. It helps the client see the layout, process and expected data flow. For AI-Solutions, prototyping is an affordable way to demonstrate the value of software solutions to potential customers.'],
        ['id'=>4,'title'=>'How Dashboards Help Managers Understand Customer Demand','category'=>'Analytics','date'=>'2026-06-02','image'=>'assets/img/article-data.svg','summary'=>'A short insight into KPI cards, review trends and enquiry reporting for decision-making.','body'=>'Dashboards convert stored records into useful business information. Counts of contact enquiries, event registrations and approved reviews help the company understand demand. This project includes dashboard pages so the admin can monitor customer activity securely.'],
        ['id'=>5,'title'=>'Building Responsive Websites for Digital Employee Experience','category'=>'Web Software','date'=>'2026-06-10','image'=>'assets/img/service-webai.svg','summary'=>'Responsive layouts help the same system work well on desktop, tablet and mobile devices.','body'=>'A responsive design is important because users may view the website on different screen sizes. This system uses flexible grids, a hamburger menu and mobile-friendly forms to keep the website usable on desktop, tablet and phone screens.'],
        ['id'=>6,'title'=>'Validation Rules That Improve Data Quality','category'=>'Development','date'=>'2026-06-18','image'=>'assets/img/service-automation.svg','summary'=>'Live validation and server validation reduce incorrect form submissions and improve stored records.','body'=>'Validation improves data quality by checking fields before they are stored. This website validates names, email addresses, phone numbers, country selection, job titles and required text. It also repeats the same checks on the server so incorrect values cannot be saved by bypassing the browser.' ]
    ];
}

function events(): array
{
    return [
        ['id'=>1,'title'=>'AI Virtual Assistant Demo Day','status'=>'upcoming','date'=>'2026-07-12','time'=>'10:00 AM','location'=>'Sunderland Digital Hub','category'=>'Demo','image'=>'assets/img/event-demo.svg','summary'=>'A live demonstration of AI assistant prototypes for customer support and enquiry capture.'],
        ['id'=>2,'title'=>'Business Automation Workshop','status'=>'upcoming','date'=>'2026-07-20','time'=>'2:00 PM','location'=>'Online Webinar','category'=>'Workshop','image'=>'assets/img/event-workshop.svg','summary'=>'A workshop showing how businesses can automate forms, approvals and reporting.'],
        ['id'=>3,'title'=>'Digital Employee Experience Session','status'=>'upcoming','date'=>'2026-08-04','time'=>'11:30 AM','location'=>'AI-Solutions Office','category'=>'Seminar','image'=>'assets/img/event-career.svg','summary'=>'An information session about supporting employees through smarter digital tools.'],
        ['id'=>4,'title'=>'Prototype Showcase Evening','status'=>'past','date'=>'2026-05-18','time'=>'5:00 PM','location'=>'Sunderland Tech Centre','category'=>'Showcase','image'=>'assets/img/gallery-3.svg','summary'=>'A past event where AI-Solutions showed dashboard and assistant prototypes.'],
        ['id'=>5,'title'=>'Client Feedback Networking Event','status'=>'past','date'=>'2026-06-05','time'=>'4:00 PM','location'=>'Innovation Centre','category'=>'Networking','image'=>'assets/img/gallery-6.svg','summary'=>'A past event used to collect comments and feedback on prototype ideas.']
    ];
}

function gallery_images(): array
{
    return [
        ['image'=>'assets/img/gallery-1.svg','title'=>'Promotional AI Event'],
        ['image'=>'assets/img/gallery-2.svg','title'=>'Client Workshop'],
        ['image'=>'assets/img/gallery-3.svg','title'=>'Prototype Showcase'],
        ['image'=>'assets/img/gallery-4.svg','title'=>'Networking Event'],
        ['image'=>'assets/img/gallery-5.svg','title'=>'Technical Presentation'],
        ['image'=>'assets/img/gallery-6.svg','title'=>'Feedback Session'],
        ['image'=>'assets/img/gallery-7.svg','title'=>'Admin Dashboard Demo'],
        ['image'=>'assets/img/gallery-8.svg','title'=>'Event Registration Desk'],
    ];
}

function seeded_reviews(): array
{
    return [
        ['name'=>'Aarav Sharma','subject'=>'Helpful prototype delivery','rating'=>5,'review'=>'The prototype was easy to understand and the admin dashboard made enquiry tracking clear.'],
        ['name'=>'Maya Rai','subject'=>'Excellent support automation','rating'=>5,'review'=>'The AI-Solutions team explained how customer support automation can reduce repeated manual work.'],
        ['name'=>'Liam Carter','subject'=>'Good event experience','rating'=>4,'review'=>'The event demo was useful and the registration process was simple on a mobile screen.'],
    ];
}

function star_rating($rating): string
{
    $rating = (int)$rating;
    return str_repeat('★', $rating) . str_repeat('☆', max(0, 5 - $rating));
}

function get_article_by_id(int $id): ?array
{
    foreach (articles() as $article) {
        if ((int)$article['id'] === $id) {
            return $article;
        }
    }
    return null;
}

function get_event_by_id(int $id): ?array
{
    foreach (events() as $event) {
        if ((int)$event['id'] === $id) {
            return $event;
        }
    }
    return null;
}
