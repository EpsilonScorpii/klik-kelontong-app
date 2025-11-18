<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\UserPaymentMethod;
use Illuminate\Support\Facades\Auth;

class PaymentMethods extends Component
{
    public $savedCards = [];
    public $ewallets = [];
    public $showAddCardModal = false;
    
    // Form data
    public $cardHolderName = '';
    public $cardNumber = '';
    public $expiryDate = '';
    public $cvv = '';
    public $cardType = 'visa';
    public $saveCard = true;

    public function mount()
    {
        $this->loadPaymentMethods();
        $this->cardHolderName = strtoupper(Auth::user()->name);
    }

    public function render()
    {
        return view('livewire.user.payment-methods')
                    ->layout('layouts.app', ['title' => 'Pembayaran']);
    }

    private function loadPaymentMethods()
    {
        // Load Cards
        $this->savedCards = UserPaymentMethod::where('user_id', Auth::id())
                                             ->where('type', 'card')
                                             ->get()
                                             ->toArray();
        
        // Load E-wallets
        $this->ewallets = UserPaymentMethod::where('user_id', Auth::id())
                                           ->where('type', 'ewallet')
                                           ->get()
                                           ->toArray();
    }

    public function toggleAddCardModal()
    {
        $this->showAddCardModal = !$this->showAddCardModal;
        
        if (!$this->showAddCardModal) {
            $this->reset(['cardHolderName', 'cardNumber', 'expiryDate', 'cvv', 'cardType', 'saveCard']);
            $this->cardHolderName = strtoupper(Auth::user()->name);
        }
    }

    public function saveNewCard()
    {
        $this->validate([
            'cardHolderName' => 'required|string|max:100',
            'cardNumber' => 'required|numeric|digits:16',
            'expiryDate' => 'required|regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/',
            'cvv' => 'required|numeric|digits:3',
        ], [
            'cardHolderName.required' => 'Nama pemegang kartu wajib diisi',
            'cardNumber.required' => 'Nomor kartu wajib diisi',
            'cardNumber.digits' => 'Nomor kartu harus 16 digit',
            'expiryDate.required' => 'Tanggal kadaluarsa wajib diisi',
            'expiryDate.regex' => 'Format tanggal harus MM/YY',
            'cvv.required' => 'CVV wajib diisi',
            'cvv.digits' => 'CVV harus 3 digit',
        ]);

        try {
            // Detect card type from first digit
            $firstDigit = substr($this->cardNumber, 0, 1);
            $cardType = $firstDigit == '4' ? 'visa' : ($firstDigit == '5' ? 'mastercard' : 'card');

            UserPaymentMethod::create([
                'user_id' => Auth::id(),
                'type' => 'card',
                'card_type' => $cardType,
                'card_holder_name' => $this->cardHolderName,
                'card_number' => $this->cardNumber,
                'expiry_date' => $this->expiryDate,
                'is_default' => $this->saveCard,
            ]);

            $this->loadPaymentMethods();
            $this->toggleAddCardModal();

            $this->dispatch('notify', [
                'message' => '✅ Kartu berhasil ditambahkan',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => '❌ Gagal menambahkan kartu: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function deletePaymentMethod($id)
    {
        try {
            UserPaymentMethod::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->delete();
            
            $this->loadPaymentMethods();
            
            $this->dispatch('notify', [
                'message' => '✅ Metode pembayaran berhasil dihapus',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => '❌ Gagal menghapus: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function linkEwallet($provider)
    {
        $this->dispatch('notify', [
            'message' => 'ℹ️ Fitur link ' . ucfirst($provider) . ' akan segera hadir',
            'type' => 'info'
        ]);
    }

    public function unlinkEwallet($id)
    {
        try {
            $ewallet = UserPaymentMethod::find($id);
            $ewallet->update([
                'is_linked' => false,
                'ewallet_account' => null,
            ]);
            
            $this->loadPaymentMethods();
            
            $this->dispatch('notify', [
                'message' => '✅ E-wallet berhasil diputus',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => '❌ Gagal memutus: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }
}