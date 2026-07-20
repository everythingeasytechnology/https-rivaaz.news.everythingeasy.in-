@extends('layouts.admin')

@section('title', 'Weather API & Locations Configuration')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold text-gray-800">Weather API & Locations</h1>
        <p class="text-muted small mb-0">Manage your Weather API Key and select target cities to display in the weather widget.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="{{ route('admin.weather.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Weather API Key -->
            <div class="mb-4">
                <label for="weather_api_key" class="form-label small fw-bold text-uppercase">Weather API Key</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-primary"></i></span>
                    <input type="text" name="weather_api_key" id="weather_api_key" class="form-control rounded-end-3 @error('weather_api_key') is-invalid @enderror" placeholder="e.g. 8f92a3c74b..." value="{{ old('weather_api_key', $setting->weather_api_key) }}">
                </div>
                <div class="form-text small text-muted">
                    Enter your WeatherAPI or OpenWeatherMap API key. Leave empty to use standard live simulated feed.
                </div>
                @error('weather_api_key')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Target Locations / Cities -->
            <div class="mb-4">
                <label for="weather_locations" class="form-label small fw-bold text-uppercase">Target Locations / Cities</label>
                <textarea name="weather_locations" id="weather_locations" rows="4" class="form-control rounded-3 @error('weather_locations') is-invalid @enderror" placeholder="e.g. Dehradun, Haridwar, Nainital, New Delhi">{{ old('weather_locations', $setting->weather_locations ?? 'Dehradun, Haridwar, Nainital, New Delhi') }}</textarea>
                <div class="form-text small text-muted">
                    Enter comma-separated city names (e.g. <code>Dehradun, Haridwar, Nainital, New Delhi</code>). These cities will be queried and displayed in the weather widget.
                </div>
                @error('weather_locations')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                    <i class="fas fa-save me-2"></i>Save Weather Configuration
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
