<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Detainee;
use Illuminate\Support\Facades\DB;

class DetaineeStatisticsBlock extends Component
{
    public $title = "إحصائيات المعتقلين";
    public $subtitle = "إحصائيات وأرقام المعتقلين والمفقودين في السودان";
    public $displayLocations = true;
    public $displayAuthorities = true;
    public $layout = 'grid'; // grid or list
    public $colorScheme = 'default'; // default, primary, dark

    // Computed properties
    public function getDetaineeStatsProperty()
    {
        // Get counts by status
        $allStatuses = Detainee::where('is_approved', true)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $total = array_sum($allStatuses);
        $allStatuses['total'] = $total;
        
        return $allStatuses;
    }

    public function getDetaineeLocationsProperty()
    {
        if (!$this->displayLocations) {
            return [];
        }
        
        // Get top 5 locations
        return Detainee::where('is_approved', true)
            ->whereNotNull('location')
            ->select('location', DB::raw('count(*) as total'))
            ->groupBy('location')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function getDetaineeAuthoritiesProperty()
    {
        if (!$this->displayAuthorities) {
            return [];
        }
        
        // Get top 5 detaining authorities
        return Detainee::where('is_approved', true)
            ->whereNotNull('detaining_authority')
            ->select('detaining_authority', DB::raw('count(*) as total'))
            ->groupBy('detaining_authority')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function getStatusInfoProperty()
    {
        return [
            'detained' => ['label' => 'معتقل', 'icon' => 'user-lock', 'color' => 'danger'],
            'kidnapped' => ['label' => 'مختطف', 'icon' => 'user-shield', 'color' => 'warning'],
            'missing' => ['label' => 'مفقود', 'icon' => 'user-slash', 'color' => 'info'],
            'released' => ['label' => 'مفرج عنه', 'icon' => 'user-check', 'color' => 'success'],
            'martyr' => ['label' => 'شهيد', 'icon' => 'user-alt-slash', 'color' => 'dark'],
            'total' => ['label' => 'الإجمالي', 'icon' => 'users', 'color' => 'primary'],
        ];
    }

    public function render()
    {
        return view('livewire.detainee-statistics-block');
    }
} 