@extends('backend.layout.app')

@section('title', 'Site Settings')

@section('content')
<div class="content-wrapper">
    <!-- Enhanced Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4 align-items-center">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle p-3 mr-3">
                            <i class="fas fa-cogs text-white fa-lg"></i>
                        </div>
                        <div>
                            <h1 class="m-0 text-dark font-weight-bold">Site Settings</h1>
                            <p class="text-muted mb-0">Configure your website settings and preferences</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 text-sm-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-primary">
                                    <i class="fas fa-home mr-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Site Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Settings Form with Tabs -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-edit mr-2"></i>Website Configuration
                    </h3>
                </div>

                <!-- Tab Navigation -->
                <div class="card-body p-0">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab">
                                <i class="fas fa-info-circle mr-2"></i>General
                            </a>
                            <a class="nav-item nav-link" id="nav-branding-tab" data-toggle="tab" href="#nav-branding" role="tab">
                                <i class="fas fa-palette mr-2"></i>Branding
                            </a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab">
                                <i class="fas fa-address-book mr-2"></i>Contact
                            </a>
                            <a class="nav-item nav-link" id="nav-social-tab" data-toggle="tab" href="#nav-social" role="tab">
                                <i class="fas fa-share-alt mr-2"></i>Social Media
                            </a>
                            <a class="nav-item nav-link" id="nav-seo-tab" data-toggle="tab" href="#nav-seo" role="tab">
                                <i class="fas fa-search mr-2"></i>SEO
                            </a>
                        </div>
                    </nav>

                    <form action="{{ route('admin.web_setting.update') }}" method="POST" enctype="multipart/form-data" class="p-4">
                        @csrf

                        <div class="tab-content" id="nav-tabContent">
                            <!-- General Tab -->
                            <div class="tab-pane fade show active" id="nav-general" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h5 class="text-primary border-bottom pb-2 mb-4">
                                            <i class="fas fa-building mr-2"></i>Basic Information
                                        </h5>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bold text-dark">
                                                <i class="fas fa-tag mr-2 text-primary"></i>Application Name
                                            </label>
                                            <input type="text" name="name" id="name" class="form-control form-control-lg border-left-primary"
                                                   value="{{ old('name', $siteSetting->name ?? '') }}" placeholder="Enter your app name">
                                            <small class="form-text text-muted">This will appear as your website title</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="moto" class="font-weight-bold text-dark">
                                                <i class="fas fa-quote-left mr-2 text-primary"></i>Motto/Tagline
                                            </label>
                                            <input type="text" name="moto" id="moto" class="form-control form-control-lg border-left-primary"
                                                   value="{{ old('moto', $siteSetting->moto ?? '') }}" placeholder="Your company motto">
                                            <small class="form-text text-muted">A brief description of your business</small>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="form-group">
                                            <label for="opening_closing_days" class="font-weight-bold text-dark">
                                                <i class="fas fa-clock mr-2 text-primary"></i>Business Hours
                                            </label>
                                            <textarea name="opening_closing_days" id="opening_closing_days" class="form-control border-left-primary"
                                                      rows="4" placeholder="e.g., Monday - Friday: 9:00 AM - 6:00 PM">{{ old('opening_closing_days', $siteSetting->opening_closing_days ?? '') }}</textarea>
                                            <small class="form-text text-muted">Describe your operating hours and days</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Branding Tab -->
                            <div class="tab-pane fade" id="nav-branding" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h5 class="text-primary border-bottom pb-2 mb-4">
                                            <i class="fas fa-image mr-2"></i>Visual Identity
                                        </h5>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="logo" class="font-weight-bold text-dark">
                                                <i class="fas fa-image mr-2 text-primary"></i>Logo
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" name="logo" class="custom-file-input" id="logo" accept="image/*">
                                                <label class="custom-file-label" for="logo">Choose logo file...</label>
                                            </div>
                                            @if($siteSetting?->logo)
                                                <div class="mt-3 p-3 bg-light rounded text-center">
                                                    <img src="{{ asset($siteSetting->logo) }}" class="img-thumbnail shadow-sm" style="max-height: 100px;">
                                                    <p class="text-muted mt-2 mb-0">Current Logo</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="favicon" class="font-weight-bold text-dark">
                                                <i class="fas fa-star mr-2 text-primary"></i>Favicon
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" name="favicon" class="custom-file-input" id="favicon" accept="image/*">
                                                <label class="custom-file-label" for="favicon">Choose favicon file...</label>
                                            </div>
                                            @if($siteSetting?->favicon)
                                                <div class="mt-3 p-3 bg-light rounded text-center">
                                                    <img src="{{ asset($siteSetting->favicon) }}" class="img-thumbnail shadow-sm" style="max-height: 50px;">
                                                    <p class="text-muted mt-2 mb-0">Current Favicon</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 mb-4">
                                        <h6 class="text-secondary border-bottom pb-2 mb-4">Color Scheme</h6>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="primary_color" class="font-weight-bold text-dark">
                                                <i class="fas fa-palette mr-2 text-primary"></i>Primary Color
                                            </label>
                                            <div class="input-group">
                                                <input type="color" name="primary_color" id="primary_color" class="form-control form-control-color"
                                                       value="{{ old('primary_color', $siteSetting->primary_color ?? '#007bff') }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">{{ old('primary_color', $siteSetting->primary_color ?? '#007bff') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="secondary_color" class="font-weight-bold text-dark">
                                                <i class="fas fa-palette mr-2 text-secondary"></i>Secondary Color
                                            </label>
                                            <div class="input-group">
                                                <input type="color" name="secondary_color" id="secondary_color" class="form-control form-control-color"
                                                       value="{{ old('secondary_color', $siteSetting->secondary_color ?? '#6c757d') }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">{{ old('secondary_color', $siteSetting->secondary_color ?? '#6c757d') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Tab -->
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h5 class="text-primary border-bottom pb-2 mb-4">
                                            <i class="fas fa-contact-card mr-2"></i>Contact Information
                                        </h5>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <div class="form-group">
                                            <label for="phone" class="font-weight-bold text-dark">
                                                <i class="fas fa-phone mr-2 text-success"></i>Phone Number
                                            </label>
                                            <input type="text" name="phone" id="phone" class="form-control form-control-lg border-left-success"
                                                   value="{{ old('phone', $siteSetting->phone ?? '') }}" placeholder="+1 (555) 123-4567">
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <div class="form-group">
                                            <label for="email" class="font-weight-bold text-dark">
                                                <i class="fas fa-envelope mr-2 text-info"></i>Email Address
                                            </label>
                                            <input type="email" name="email" id="email" class="form-control form-control-lg border-left-info"
                                                   value="{{ old('email', $siteSetting->email ?? '') }}" placeholder="contact@yoursite.com">
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <div class="form-group">
                                            <label for="address" class="font-weight-bold text-dark">
                                                <i class="fas fa-map-marker-alt mr-2 text-danger"></i>Address
                                            </label>
                                            <input type="text" name="address" id="address" class="form-control form-control-lg border-left-danger"
                                                   value="{{ old('address', $siteSetting->address ?? '') }}" placeholder="123 Main St, City, State">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="form-group">
                                            <label for="google_map_embed" class="font-weight-bold text-dark">
                                                <i class="fas fa-map mr-2 text-warning"></i>Google Map Embed Code
                                            </label>
                                            <textarea name="google_map_embed" id="google_map_embed" class="form-control border-left-warning"
                                                      rows="4" placeholder="Paste your Google Maps embed code here...">{{ old('google_map_embed', $siteSetting->google_map_embed ?? '') }}</textarea>
                                            <small class="form-text text-muted">Get embed code from Google Maps → Share → Embed a map</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media Tab -->
                            <div class="tab-pane fade" id="nav-social" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h5 class="text-primary border-bottom pb-2 mb-4">
                                            <i class="fas fa-share-alt mr-2"></i>Social Media Links
                                        </h5>
                                    </div>

                                    @php
                                        $oldSocial = old('social_media', $siteSetting->social_media ?? []);
                                        $socialPlatforms = [
                                            'facebook' => ['icon' => 'fab fa-facebook-f', 'color' => 'primary', 'placeholder' => 'https://facebook.com/yourpage'],
                                            'twitter' => ['icon' => 'fab fa-twitter', 'color' => 'info', 'placeholder' => 'https://twitter.com/youraccount'],
                                            'instagram' => ['icon' => 'fab fa-instagram', 'color' => 'danger', 'placeholder' => 'https://instagram.com/youraccount'],
                                            'linkedin' => ['icon' => 'fab fa-linkedin-in', 'color' => 'primary', 'placeholder' => 'https://linkedin.com/company/yourcompany']
                                        ];
                                    @endphp

                                    @foreach($socialPlatforms as $platform => $config)
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="{{ $platform }}" class="font-weight-bold text-dark">
                                                    <i class="{{ $config['icon'] }} mr-2 text-{{ $config['color'] }}"></i>{{ ucfirst($platform) }}
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-{{ $config['color'] }} text-white">
                                                            <i class="{{ $config['icon'] }}"></i>
                                                        </span>
                                                    </div>
                                                    <input type="url" name="social_media[{{ $platform }}]" id="{{ $platform }}"
                                                           class="form-control border-left-{{ $config['color'] }}"
                                                           value="{{ isset($oldSocial[$platform]) ? (is_array($oldSocial[$platform]) ? '' : $oldSocial[$platform]) : '' }}"
                                                           placeholder="{{ $config['placeholder'] }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- SEO Tab -->
                            <div class="tab-pane fade" id="nav-seo" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h5 class="text-primary border-bottom pb-2 mb-4">
                                            <i class="fas fa-search-plus mr-2"></i>Search Engine Optimization
                                        </h5>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="meta_title" class="font-weight-bold text-dark">
                                                <i class="fas fa-heading mr-2 text-primary"></i>Meta Title
                                            </label>
                                            <input type="text" name="meta_title" id="meta_title" class="form-control form-control-lg border-left-primary"
                                                   value="{{ old('meta_title', $siteSetting->meta_title ?? '') }}"
                                                   placeholder="Your Website Title - Keep it under 60 characters" maxlength="60">
                                            <small class="form-text text-muted">
                                                <span id="title-counter">0</span>/60 characters - This appears in search results
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="meta_description" class="font-weight-bold text-dark">
                                                <i class="fas fa-file-alt mr-2 text-info"></i>Meta Description
                                            </label>
                                            <textarea name="meta_description" id="meta_description" class="form-control border-left-info"
                                                      rows="4" maxlength="160"
                                                      placeholder="Brief description of your website for search engines...">{{ old('meta_description', $siteSetting->meta_description ?? '') }}</textarea>
                                            <small class="form-text text-muted">
                                                <span id="desc-counter">0</span>/160 characters - This appears below the title in search results
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Submit Section -->
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="bg-light rounded p-4 text-center">
                                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                                        <i class="fas fa-save mr-2"></i>Update Settings
                                    </button>
                                    <p class="text-muted mt-2 mb-0">All changes will be applied immediately</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('customJs')
<script>
$(document).ready(function() {
    // File input labels
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });

    // Character counters
    function updateCounter(input, counter, max) {
        const length = $(input).val().length;
        $(counter).text(length);

        if (length > max * 0.8) {
            $(counter).removeClass('text-muted').addClass('text-warning');
        } else if (length > max * 0.9) {
            $(counter).removeClass('text-warning').addClass('text-danger');
        } else {
            $(counter).removeClass('text-warning text-danger').addClass('text-muted');
        }
    }

    $('#meta_title').on('input', function() {
        updateCounter(this, '#title-counter', 60);
    });

    $('#meta_description').on('input', function() {
        updateCounter(this, '#desc-counter', 160);
    });

    // Initialize counters
    updateCounter('#meta_title', '#title-counter', 60);
    updateCounter('#meta_description', '#desc-counter', 160);

    // Color picker updates
    $('input[type="color"]').on('change', function() {
        $(this).siblings('.input-group-append').find('span').text($(this).val());
    });

    // Tab persistence
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });

    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#nav-tab a[href="' + activeTab + '"]').tab('show');
    }

    // Form validation styling
    $('form').on('submit', function() {
        $(this).find('.btn[type="submit"]').html('<i class="fas fa-spinner fa-spin mr-2"></i>Updating...').prop('disabled', true);
    });
});
</script>

<style>
.border-left-primary { border-left: 3px solid #007bff !important; }
.border-left-success { border-left: 3px solid #28a745 !important; }
.border-left-info { border-left: 3px solid #17a2b8 !important; }
.border-left-warning { border-left: 3px solid #ffc107 !important; }
.border-left-danger { border-left: 3px solid #dc3545 !important; }
.border-left-secondary { border-left: 3px solid #6c757d !important; }

.form-control-color {
    width: 80px;
    height: 40px;
    padding: 2px;
}

.nav-tabs .nav-link {
    font-weight: 500;
    color: #495057;
    border-bottom: 3px solid transparent;
}

.nav-tabs .nav-link.active {
    color: #007bff;
    border-bottom-color: #007bff;
    background-color: transparent;
}

.nav-tabs .nav-link:hover {
    border-bottom-color: #007bff;
    color: #007bff;
}

.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.card {
    border-radius: 10px;
}

.form-control:focus, .custom-file-input:focus ~ .custom-file-label {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-success {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
    border-radius: 25px;
}

.btn-success:hover {
    background: linear-gradient(45deg, #20c997, #28a745);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
</style>
@endsection
