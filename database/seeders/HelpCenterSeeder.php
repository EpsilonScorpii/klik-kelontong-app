<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;
use App\Models\ContactMethod;

class HelpCenterSeeder extends Seeder
{
    public function run()
    {
        // FAQs
        $faqs = [
            [
                'category' => 'services',
                'question' => 'Can I track my order\'s delivery status?',
                'answer' => 'You can track your order\'s delivery status directly from your order history or via the tracking link we\'ve sent to your email. Let us know if you need help!',
                'order' => 1,
            ],
            [
                'category' => 'services',
                'question' => 'How do I customer support?',
                'answer' => 'You can contact our customer support via WhatsApp, Instagram, or email. We are available 24/7 to assist you.',
                'order' => 2,
            ],
            [
                'category' => 'general',
                'question' => 'What payment methods are accepted?',
                'answer' => 'We accept various payment methods including bank transfer, credit/debit cards, e-wallets (GoPay, OVO, Dana), and cash on delivery.',
                'order' => 3,
            ],
            [
                'category' => 'general',
                'question' => 'How to see review product',
                'answer' => 'You can see product reviews on the product detail page. Click on the "Reviews" tab to see customer feedback and ratings.',
                'order' => 4,
            ],
            [
                'category' => 'account',
                'question' => 'How do I reset my password?',
                'answer' => 'Click on "Forgot Password" on the login page. Enter your email address and we will send you a link to reset your password.',
                'order' => 5,
            ],
            [
                'category' => 'account',
                'question' => 'How do I update my profile?',
                'answer' => 'Go to your Account Settings and click on "Edit Profile". You can update your personal information, address, and phone number.',
                'order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        // Contact Methods
        $contacts = [
            [
                'type' => 'customer_service',
                'label' => 'Customer Service',
                'value' => '0812-3456-7890',
                'url' => 'tel:+6281234567890',
            ],
            [
                'type' => 'whatsapp',
                'label' => 'WhatsApp',
                'value' => '0812-3456-7890',
                'url' => 'https://wa.me/6281234567890',
            ],
            [
                'type' => 'instagram',
                'label' => 'Instagram',
                'value' => '@klikkelontong',
                'url' => 'https://instagram.com/klikkelontong',
            ],
        ];

        foreach ($contacts as $contact) {
            ContactMethod::create($contact);
        }
    }
}