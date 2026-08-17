<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function handle(Request $request)
    {
        $message = strtolower(trim($request->input('message', '')));

        $kb = [
            [
                'keys' => ['hi','hello','hey','good morning','good evening','good afternoon','howdy'],
                'answer' => "Welcome to Onyx Haven! I'm your personal concierge. I can help you find rooms, understand our booking process, or navigate the site. What can I do for you?",
                'replies' => ['Show me the rooms', 'How do I book?', 'What is Onyx Haven?'],
            ],
            [
                'keys' => ['what is onyx','about','tell me about','who are you','what are you'],
                'answer' => "Onyx Haven is a boutique luxury hotel with a small, carefully curated collection of rooms, from garden retreats to a full-floor penthouse. Every detail is intentional. You can read our full story on the About page.",
                'replies' => ['Visit About page', 'Show me rooms', 'What experiences do you offer?'],
                'links' => [['label' => 'Visit About page', 'url' => '/about']],
            ],
            [
                'keys' => ['room','rooms','suite','suites','available','collection','see rooms','show rooms','view rooms'],
                'answer' => "We have 5 rooms in our collection, from the Obsidian Deluxe Room (NGN 500,000/night) to the Haven Penthouse (NGN 4,000,000/night). Each has its own character and view. Head to the Rooms page to browse and filter by view type, price, or guests.",
                'replies' => ['Browse all rooms', 'How do I book a room?', 'What views are available?'],
                'links' => [['label' => 'Browse all rooms', 'url' => '/rooms']],
            ],
            [
                'keys' => ['price','cost','how much','rate','rates','expensive','affordable'],
                'answer' => "Our rooms range from NGN 500,000/night (Obsidian Deluxe Room) up to NGN 4,000,000/night (Haven Penthouse). You can filter by budget on the Rooms page.",
                'replies' => ['See all rooms', 'How do I book?'],
                'links' => [['label' => 'See all rooms', 'url' => '/rooms']],
            ],
            [
                'keys' => ['view','views','ocean','city','garden','panoramic','scenery'],
                'answer' => "We offer four view types: city, ocean, garden, and panoramic. You can filter by view type on the Rooms page to find exactly what you're looking for.",
                'replies' => ['Browse rooms by view'],
                'links' => [['label' => 'Browse rooms by view', 'url' => '/rooms']],
            ],
            [
                'keys' => ['book','booking','reserve','reservation','how to book','make a booking'],
                'answer' => "Booking is straightforward:\n1. Browse rooms at /rooms\n2. Click 'Book Room' on your chosen room\n3. Fill in your dates, guests, and details\n4. Complete payment on the next screen\n\nThe whole process takes under 2 minutes.",
                'replies' => ['Browse rooms to book', 'How does payment work?'],
                'links' => [['label' => 'Browse rooms to book', 'url' => '/rooms']],
            ],
            [
                'keys' => ['pay','payment','card','credit','debit','how to pay','checkout'],
                'answer' => "We accept Visa, Mastercard, and Amex. Payment is collected securely after you fill in your booking details. You'll be asked for your card number, expiry, and CVV, then you're confirmed instantly.",
                'replies' => ['Start a booking', 'Is it secure?'],
                'links' => [['label' => 'Start a booking', 'url' => '/rooms']],
            ],
            [
                'keys' => ['secure','security','safe','ssl','encrypted','trust'],
                'answer' => "All payments are processed over a 256-bit SSL encrypted connection. Your card details are never stored, only the last 4 digits are saved for your receipt.",
                'replies' => ['How do I book?', 'Show me rooms'],
            ],
            [
                'keys' => ['cancel','cancellation','refund','change booking'],
                'answer' => "To cancel a booking, please contact us directly, we don't currently have a self-serve cancellation page. Our team will sort it out for you promptly.",
                'replies' => ['How do I contact you?', 'Show me rooms'],
            ],
            [
                'keys' => ['check in','check-in','checkin','arrival','arrive'],
                'answer' => "Standard check-in is from 3:00 PM. Early check-in may be available on request, mention it in the special requests field when booking.",
                'replies' => ['How do I book?', 'What about check-out?'],
            ],
            [
                'keys' => ['check out','check-out','checkout','departure','leave'],
                'answer' => "Standard check-out is by 11:00 AM. Late check-out may be available depending on the day, just ask when you arrive.",
                'replies' => ['What about check-in?', 'How do I book?'],
            ],
            [
                'keys' => ['experience','experiences','spa','dining','restaurant','concierge','activities'],
                'answer' => "Beyond the room, Onyx Haven offers rooftop dining, The Onyx Spa (volcanic stone treatments), and a personal concierge for the length of your stay. Explore it all on the Experiences page.",
                'replies' => ['Visit Experiences page', 'Show me rooms'],
                'links' => [['label' => 'Visit Experiences page', 'url' => '/experiences']],
            ],
            [
                'keys' => ['contact','reach','email','phone','call','talk to','speak','human','person'],
                'answer' => "For direct enquiries, reach our team at hello@onyxhaven.com. For urgent matters during your stay, your personal concierge is available 24/7.",
                'replies' => ['How do I book?', 'What experiences do you offer?'],
            ],
            [
                'keys' => ['thank','thanks','thank you','appreciate','great','perfect','helpful','awesome'],
                'answer' => "You're very welcome! Is there anything else I can help you with before your stay?",
                'replies' => ['Browse rooms', 'How do I book?'],
            ],
            [
                'keys' => ["no i'm good","no thanks","that's all","nothing else","bye","goodbye","see you"],
                'answer' => "Have a wonderful stay at Onyx Haven. We look forward to welcoming you.",
                'replies' => ['Browse rooms', 'Back to home'],
                'links' => [
                    ['label' => 'Browse rooms', 'url' => '/rooms'],
                    ['label' => 'Back to home', 'url' => '/'],
                ],
            ],
        ];

        foreach ($kb as $entry) {
            foreach ($entry['keys'] as $key) {
                if (str_contains($message, $key)) {
                    return response()->json([
                        'answer' => $entry['answer'],
                        'replies' => $entry['replies'] ?? [],
                        'links' => $entry['links'] ?? [],
                    ]);
                }
            }
        }

        return response()->json([
            'answer' => "I'm not sure about that one, but I can help you browse rooms, understand booking and payment, or find your way around the site. What would you like to know?",
            'replies' => ['Show me rooms', 'How do I book?', 'Tell me about Onyx Haven'],
            'links' => [],
        ]);
    }
}