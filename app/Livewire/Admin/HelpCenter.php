<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Faq;
use App\Models\ContactMethod;

class HelpCenter extends Component
{
    public $activeTab = 'faq';
    public $selectedCategory = 'all';
    public $faqs = [];
    public $contactMethods = [];
    public $expandedFaqId = null;
    public $expandedContactId = null;

    public function mount()
    {
        $this->loadFaqs();
        $this->loadContactMethods();
    }

    public function render()
    {
        return view('livewire.admin.help-center')
                    ->layout('layouts.admin', ['title' => 'Pusat Bantuan']);
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->expandedFaqId = null;
        $this->expandedContactId = null;
    }

    public function selectCategory($category)
    {
        $this->selectedCategory = $category;
        $this->loadFaqs();
        $this->expandedFaqId = null;
    }

    public function toggleFaq($faqId)
    {
        $this->expandedFaqId = $this->expandedFaqId === $faqId ? null : $faqId;
    }

    public function toggleContact($contactId)
    {
        $this->expandedContactId = $this->expandedContactId === $contactId ? null : $contactId;
    }

    private function loadFaqs()
    {
        $query = Faq::where('is_active', true);
        
        if ($this->selectedCategory !== 'all') {
            $query->where('category', $this->selectedCategory);
        }
        
        $this->faqs = $query->orderBy('order')->get()->toArray();
    }

    private function loadContactMethods()
    {
        $this->contactMethods = ContactMethod::where('is_active', true)
                                             ->orderBy('id')
                                             ->get()
                                             ->toArray();
    }
}