<?php

namespace App\Livewire\User;

use Livewire\Component;

class HelpCenter extends Component
{
    public $activeTab = 'faq'; // faq or contact
    public $activeFaqCategory = 'all'; // all, services, general, account
    public $expandedFaq = null;
    public $expandedContact = null;

    public $faqs = [];
    public $contactMethods = [];

    public function mount()
    {
        $this->loadFaqs();
        $this->loadContactMethods();
    }

    public function render()
    {
        return view('livewire.user.help-center')->layout('layouts.app', ['title' => 'Help Center']);
    }

    private function loadFaqs()
    {
        $this->faqs = [
            [
                'id' => 1,
                'category' => 'services',
                'question' => 'Can I track my order\'s delivery status?',
                'answer' => 'You can track your order\'s delivery status directly from your order history or via the tracking link we\'ve sent to your email. Let us know if you need help!'
            ],
            [
                'id' => 2,
                'category' => 'services',
                'question' => 'How do I customer support?',
                'answer' => 'You can contact our customer support via WhatsApp at 0812-3456-7890, Instagram @klikkelontong, or through our in-app chat feature. We\'re here to help!'
            ],
            [
                'id' => 3,
                'category' => 'general',
                'question' => 'What payment methods are accepted?',
                'answer' => 'We accept various payment methods including Credit/Debit Cards, Bank Transfer, E-Wallets (GoPay, OVO, DANA), and Cash on Delivery (COD) for selected areas.'
            ],
            [
                'id' => 4,
                'category' => 'account',
                'question' => 'How to add review?',
                'answer' => 'After receiving your order, go to Order History > Select the order > Click "Review" button. You can rate products and share your experience to help other customers!'
            ],
            [
                'id' => 5,
                'category' => 'services',
                'question' => 'What is the return policy?',
                'answer' => 'You can return products within 7 days if they are damaged or not as described. Please contact customer service with order details and photos of the product.'
            ],
            [
                'id' => 6,
                'category' => 'general',
                'question' => 'How long does delivery take?',
                'answer' => 'Standard delivery takes 2-3 business days. Express delivery is available for selected areas with 1-day delivery. You\'ll receive tracking information once your order is shipped.'
            ],
            [
                'id' => 7,
                'category' => 'account',
                'question' => 'How to change my password?',
                'answer' => 'Go to Account > Settings > Password Manager. Enter your current password and new password, then click "Change Password".'
            ],
            [
                'id' => 8,
                'category' => 'general',
                'question' => 'Do you offer bulk discounts?',
                'answer' => 'Yes! We offer special discounts for bulk purchases. Contact our customer service for more information about wholesale prices and minimum order quantities.'
            ],
        ];
    }

    private function loadContactMethods()
    {
        $this->contactMethods = [
            [
                'id' => 1,
                'name' => 'Customer Service',
                'icon' => 'headset',
                'type' => 'link',
                'value' => 'mailto:support@klikkelontong.com',
                'label' => 'Email Us'
            ],
            [
                'id' => 2,
                'name' => 'WhatsApp',
                'icon' => 'whatsapp',
                'type' => 'expandable',
                'phones' => [
                    '0812-3456-7890',
                    '0813-9876-5432',
                ]
            ],
            [
                'id' => 3,
                'name' => 'Instagram',
                'icon' => 'instagram',
                'type' => 'expandable',
                'accounts' => [
                    '@klikkelontong',
                    '@klikkelontong_official',
                ]
            ],
        ];
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->expandedFaq = null;
        $this->expandedContact = null;
    }

    public function switchFaqCategory($category)
    {
        $this->activeFaqCategory = $category;
        $this->expandedFaq = null;
    }

    public function toggleFaq($faqId)
    {
        $this->expandedFaq = $this->expandedFaq === $faqId ? null : $faqId;
    }

    public function toggleContact($contactId)
    {
        $this->expandedContact = $this->expandedContact === $contactId ? null : $contactId;
    }

    public function getFilteredFaqsProperty()
    {
        if ($this->activeFaqCategory === 'all') {
            return $this->faqs;
        }

        return collect($this->faqs)->filter(function($faq) {
            return $faq['category'] === $this->activeFaqCategory;
        })->toArray();
    }
}