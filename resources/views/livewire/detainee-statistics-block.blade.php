<div>
    <div class="container py-4">
        @if($title || $subtitle)
        <div class="text-center mb-4">
            @if($title)
                <h2 class="mb-2">{{ $title }}</h2>
            @endif
            @if($subtitle)
                <p class="text-muted">{{ $subtitle }}</p>
            @endif
        </div>
        @endif
        
        <!-- Status Counts -->
        <div class="row g-4 mb-5">
            @foreach($this->statusInfo as $status => $info)
                @if(isset($this->detaineeStats[$status]) && $this->detaineeStats[$status] > 0)
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-{{ $info['color'] }} mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-{{ $info['icon'] }} fa-lg text-white"></i>
                            </div>
                            <h3 class="fs-2 fw-bold mb-0">{{ $this->detaineeStats[$status] ?? 0 }}</h3>
                            <p class="text-muted mb-0">{{ $info['label'] }}</p>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <!-- Secondary Statistics -->
        @if($this->detaineeLocations || $this->detaineeAuthorities)
        <div class="row">
            <!-- Top Locations -->
            @if(count($this->detaineeLocations) > 0)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2 text-danger"></i> أكثر مناطق الاعتقال</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($this->detaineeLocations as $location)
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                                    <span>{{ $location['location'] }}</span>
                                    <span class="badge bg-primary rounded-pill">{{ $location['total'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Top Authorities -->
            @if(count($this->detaineeAuthorities) > 0)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0"><i class="fas fa-shield-alt me-2 text-warning"></i> أكثر الجهات المعتقلة</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($this->detaineeAuthorities as $authority)
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                                    <span>{{ $authority['detaining_authority'] }}</span>
                                    <span class="badge bg-warning text-dark rounded-pill">{{ $authority['total'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div> 