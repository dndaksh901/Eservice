@extends('layouts.main')

@section('meta_title', ($profile->vendor->name ?? $profile->vendor->username) . ' - ' . ($profile->occupation->occupation_name ?? 'Expert') . ' in ' . ($profile->city->name ?? 'Local Area') . ' | ' . config('app.name', 'Eservice'))
@section('meta_description', 'Book ' . ($profile->vendor->name ?? 'Professional') . ', verified ' . ($profile->occupation->occupation_name ?? 'service provider') . ' in ' . ($profile->city->name ?? '') . ', ' . ($profile->state->name ?? '') . '. ₹' . ($profile->price_per_hour ?? '') . '/hr. Contact directly via call or chat.')

@section('links')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Schema.org JSON-LD for Local Business Google Search Pack -->
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "LocalBusiness",
  "name": "{{ addslashes($profile->vendor->name ?? $profile->vendor->username) }}",
  "image": "{{ asset('vendor/vendor_image/' . ($profile->vendor->avatar ?? 'avatar.jpg')) }}",
  "telephone": "{{ $profile->vendor->mobile ?? '' }}",
  "priceRange": "₹{{ $profile->price_per_hour ?? '0' }}",
  "address": {
    "@@type": "PostalAddress",
    "streetAddress": "{{ addslashes($profile->address ?? '') }}",
    "addressLocality": "{{ addslashes($profile->city->name ?? '') }}",
    "addressRegion": "{{ addslashes($profile->state->name ?? '') }}",
    "postalCode": "{{ $profile->pincode ?? '' }}",
    "addressCountry": "IN"
  },
  "aggregateRating": {
    "@@type": "AggregateRating",
    "ratingValue": "{{ $profile->rating > 0 ? $profile->rating : '5.0' }}",
    "reviewCount": "{{ $reviews->total() > 0 ? $reviews->total() : '1' }}"
  }
}
</script>

<style>
    /* =========================================================
       PROFESSIONAL VENDOR PROFILE REDESIGN SYSTEM
       ========================================================= */
    :root {
        --vp-primary: #c10037;
        --vp-primary-hover: #a1002e;
        --vp-primary-light: rgba(193, 0, 55, 0.08);
        --vp-success: #10b981;
        --vp-success-hover: #059669;
        --vp-warning: #f59e0b;
        --vp-slate-900: #0f172a;
        --vp-slate-800: #1e293b;
        --vp-slate-700: #334155;
        --vp-slate-600: #475569;
        --vp-slate-500: #64748b;
        --vp-slate-200: #e2e8f0;
        --vp-slate-100: #f1f5f9;
        --vp-slate-50: #f8fafc;
        --vp-radius-sm: 8px;
        --vp-radius-md: 12px;
        --vp-radius-lg: 16px;
        --vp-radius-xl: 20px;
        --vp-shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.06);
        --vp-shadow-md: 0 4px 20px -2px rgba(15, 23, 42, 0.07);
        --vp-shadow-lg: 0 10px 30px -4px rgba(15, 23, 42, 0.1);
    }

    body {
        background-color: var(--vp-slate-50) !important;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Hero / Top Banner */
    .vp-hero-header {
        background: linear-gradient(135deg, #091224 0%, #111d38 50%, #1e293b 100%);
        padding: 120px 0 115px;
        position: relative;
        overflow: hidden;
    }
    .vp-hero-header::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(193, 0, 55, 0.18) 0%, transparent 70%);
        pointer-events: none;
    }
    .vp-hero-header::after {
        content: "";
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.14) 0%, transparent 70%);
        pointer-events: none;
    }
    .vp-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #94a3b8;
        margin-bottom: 12px;
        list-style: none;
        padding: 0;
    }
    .vp-breadcrumb a {
        color: #cbd5e1;
        text-decoration: none;
        transition: color 0.2s;
    }
    .vp-breadcrumb a:hover {
        color: #ffffff;
    }
    .vp-breadcrumb .separator {
        color: #64748b;
        font-size: 11px;
    }
    .vp-breadcrumb .active {
        color: #38bdf8;
        font-weight: 500;
    }

    /* Main Container Offset */
    .vp-profile-container {
        margin-top: -65px;
        position: relative;
        z-index: 10;
        padding-bottom: 70px;
    }

    /* Vendor Profile Hero Card */
    .vp-author-card {
        background: #ffffff;
        border-radius: var(--vp-radius-xl);
        box-shadow: var(--vp-shadow-lg);
        border: 1px solid rgba(226, 232, 240, 0.9);
        padding: 28px 32px;
        margin-bottom: 24px;
        transition: transform 0.2s ease;
    }
    .vp-author-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 24px;
    }
    .vp-author-info {
        display: flex;
        align-items: center;
        gap: 22px;
        flex: 1;
        min-width: 280px;
    }
    .vp-avatar-wrapper {
        position: relative;
        flex-shrink: 0;
        width: 105px;
        height: 105px;
    }
    .vp-avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #ffffff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        background: #f8fafc;
    }
    .vp-verified-badge {
        position: absolute;
        bottom: 2px;
        right: 2px;
        background: #10b981;
        color: #ffffff;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #ffffff;
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.35);
        font-size: 13px;
    }
    .vp-author-meta h1 {
        font-size: 24px;
        font-weight: 800;
        color: var(--vp-slate-900);
        margin: 0 0 6px;
        letter-spacing: -0.02em;
        line-height: 1.25;
        text-transform: capitalize;
    }
    .vp-badge-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }
    .vp-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.4;
    }
    .vp-badge-occupation {
        background: var(--vp-primary-light);
        color: var(--vp-primary);
        border: 1px solid rgba(193, 0, 55, 0.15);
    }
    .vp-badge-pro {
        background: rgba(16, 185, 129, 0.1);
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    .vp-meta-chips {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 14px;
        font-size: 13px;
        color: var(--vp-slate-600);
    }
    .vp-chip-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .vp-chip-item i {
        color: var(--vp-slate-500);
        font-size: 14px;
    }
    .vp-rating-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #fef3c7;
        color: #92400e;
        padding: 3px 9px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 12.5px;
    }
    .vp-rating-pill i {
        color: #f59e0b;
        font-size: 12px;
    }

    /* Author Card CTA on Desktop */
    .vp-author-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .vp-price-tag-hero {
        text-align: right;
        padding-right: 18px;
        border-right: 1px solid var(--vp-slate-200);
    }
    .vp-price-amount {
        font-size: 26px;
        font-weight: 800;
        color: var(--vp-slate-900);
        line-height: 1;
    }
    .vp-price-unit {
        font-size: 12px;
        color: var(--vp-slate-500);
        display: block;
        margin-top: 4px;
        font-weight: 500;
    }

    /* Sub-Navigation Quick Bar */
    .vp-quick-nav {
        background: #ffffff;
        border-radius: var(--vp-radius-md);
        box-shadow: var(--vp-shadow-sm);
        border: 1px solid var(--vp-slate-200);
        padding: 6px 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        overflow-x: auto;
    }
    .vp-nav-links {
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .vp-nav-link {
        padding: 8px 16px;
        border-radius: var(--vp-radius-sm);
        font-size: 13.5px;
        font-weight: 600;
        color: var(--vp-slate-600);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .vp-nav-link:hover, .vp-nav-link.active {
        color: var(--vp-primary);
        background: var(--vp-primary-light);
    }

    /* Content Cards */
    .vp-card {
        background: #ffffff;
        border-radius: var(--vp-radius-lg);
        box-shadow: var(--vp-shadow-sm);
        border: 1px solid var(--vp-slate-200);
        padding: 24px 28px;
        margin-bottom: 24px;
        transition: box-shadow 0.2s;
    }
    .vp-card:hover {
        box-shadow: var(--vp-shadow-md);
    }
    .vp-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 16px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--vp-slate-100);
    }
    .vp-card-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: var(--vp-slate-900);
    }
    .vp-header-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    .vp-icon-primary {
        background: var(--vp-primary-light);
        color: var(--vp-primary);
    }
    .vp-icon-success {
        background: rgba(16, 185, 129, 0.1);
        color: var(--vp-success);
    }
    .vp-icon-warning {
        background: #fef3c7;
        color: #d97706;
    }
    .vp-icon-info {
        background: #e0f2fe;
        color: #0284c7;
    }

    /* Bio / Description Typography */
    .vp-bio-content {
        color: var(--vp-slate-700);
        font-size: 15px;
        line-height: 1.75;
    }
    .vp-bio-content p {
        margin-bottom: 12px;
    }
    .vp-bio-content p:last-child {
        margin-bottom: 0;
    }
    .vp-trust-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px dashed var(--vp-slate-200);
    }
    .vp-trust-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13.5px;
        color: var(--vp-slate-700);
        font-weight: 500;
    }
    .vp-trust-item i {
        color: var(--vp-success);
        font-size: 16px;
    }

    /* Services Grid */
    .vp-services-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .vp-service-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--vp-slate-50);
        border: 1px solid var(--vp-slate-200);
        padding: 9px 18px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: 600;
        color: var(--vp-slate-800);
        transition: all 0.2s ease;
    }
    .vp-service-chip:hover {
        background: #ffffff;
        border-color: var(--vp-primary);
        color: var(--vp-primary);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(193, 0, 55, 0.08);
    }
    .vp-service-chip i {
        color: var(--vp-primary);
        font-size: 13px;
    }

    /* Portfolio Gallery Grid */
    .vp-gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 14px;
    }
    .vp-gallery-card {
        position: relative;
        border-radius: var(--vp-radius-md);
        overflow: hidden;
        aspect-ratio: 4/3;
        background: #f1f5f9;
        border: 1px solid var(--vp-slate-200);
        cursor: pointer;
    }
    .vp-gallery-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }
    .vp-gallery-card:hover img {
        transform: scale(1.08);
    }
    .vp-gallery-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.4);
        opacity: 0;
        transition: opacity 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 20px;
    }
    .vp-gallery-card:hover .vp-gallery-overlay {
        opacity: 1;
    }

    /* Reviews & Rating Section */
    .vp-reviews-summary {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 1px solid #fde68a;
        border-radius: var(--vp-radius-md);
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 24px;
    }
    .vp-big-rating {
        font-size: 38px;
        font-weight: 800;
        color: #78350f;
        line-height: 1;
    }
    .vp-stars-display {
        color: #f59e0b;
        font-size: 15px;
        margin: 4px 0 2px;
    }
    .vp-review-item {
        padding: 18px 0;
        border-bottom: 1px solid var(--vp-slate-100);
        display: flex;
        gap: 14px;
    }
    .vp-review-item:last-child {
        border-bottom: none;
    }
    .vp-reviewer-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: var(--vp-slate-700);
        font-size: 16px;
        flex-shrink: 0;
    }
    .vp-reviewer-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 4px;
    }
    .vp-reviewer-name {
        font-weight: 700;
        font-size: 14.5px;
        color: var(--vp-slate-900);
        margin: 0;
    }
    .vp-review-date {
        font-size: 12px;
        color: var(--vp-slate-500);
    }
    .vp-review-text {
        font-size: 14px;
        color: var(--vp-slate-700);
        line-height: 1.6;
        margin: 6px 0 0;
    }

    /* Star Rating Selector Form */
    .vp-star-rating-box {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 6px;
        margin: 8px 0 16px;
    }
    .vp-star-rating-box input {
        display: none;
    }
    .vp-star-rating-box label {
        cursor: pointer;
        font-size: 28px;
        color: #cbd5e1;
        transition: color 0.15s;
    }
    .vp-star-rating-box label::before {
        content: '★';
    }
    .vp-star-rating-box input:checked ~ label,
    .vp-star-rating-box label:hover,
    .vp-star-rating-box label:hover ~ label {
        color: #f59e0b;
    }

    /* Sidebar Sticky Booking Card */
    .vp-sidebar-sticky {
        position: sticky;
        top: 90px;
        z-index: 20;
    }
    .vp-booking-card {
        background: #ffffff;
        border-radius: var(--vp-radius-xl);
        box-shadow: var(--vp-shadow-lg);
        border: 1px solid var(--vp-slate-200);
        padding: 26px 24px;
        margin-bottom: 22px;
    }
    .vp-booking-price-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        padding-bottom: 16px;
        margin-bottom: 18px;
        border-bottom: 1px solid var(--vp-slate-100);
    }
    .vp-price-large {
        font-size: 30px;
        font-weight: 800;
        color: var(--vp-slate-900);
        letter-spacing: -0.02em;
    }
    .vp-price-subtext {
        font-size: 13px;
        color: var(--vp-slate-500);
        font-weight: 500;
    }
    .vp-avail-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 700;
        background: rgba(16, 185, 129, 0.12);
        color: #065f46;
        padding: 4px 10px;
        border-radius: 999px;
    }
    .vp-pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: vpPulse 1.8s infinite;
    }
    @keyframes vpPulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* High-Converting Buttons */
    .vp-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 13px 20px;
        border-radius: var(--vp-radius-md);
        font-size: 14.5px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        box-shadow: var(--vp-shadow-sm);
        margin-bottom: 10px;
    }
    .vp-btn:last-child {
        margin-bottom: 0;
    }
    .vp-btn-chat {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff !important;
    }
    .vp-btn-chat:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        color: #ffffff !important;
        transform: translateY(-1px);
    }
    .vp-btn-message {
        background: linear-gradient(135deg, #c10037 0%, #e11d48 100%);
        color: #ffffff !important;
    }
    .vp-btn-message:hover {
        background: linear-gradient(135deg, #a1002e 0%, #be123c 100%);
        box-shadow: 0 4px 14px rgba(193, 0, 55, 0.35);
        color: #ffffff !important;
        transform: translateY(-1px);
    }
    .vp-btn-call {
        background: var(--vp-slate-900);
        color: #ffffff !important;
    }
    .vp-btn-call:hover {
        background: #000000;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.3);
        color: #ffffff !important;
        transform: translateY(-1px);
    }

    /* Contact Details List */
    .vp-contact-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .vp-contact-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--vp-slate-100);
        font-size: 13.5px;
    }
    .vp-contact-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .vp-contact-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: var(--vp-slate-100);
        color: var(--vp-slate-600);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .vp-contact-row a {
        color: var(--vp-slate-800);
        text-decoration: none;
        font-weight: 600;
        word-break: break-all;
        transition: color 0.2s;
    }
    .vp-contact-row a:hover {
        color: var(--vp-primary);
    }
    .vp-contact-label {
        font-size: 11.5px;
        color: var(--vp-slate-500);
        display: block;
        margin-bottom: 2px;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.03em;
    }

    /* Social Icons Cluster */
    .vp-social-cluster {
        display: flex;
        gap: 8px;
        margin-top: 14px;
    }
    .vp-social-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff !important;
        font-size: 15px;
        text-decoration: none;
        transition: transform 0.2s, opacity 0.2s;
    }
    .vp-social-btn:hover {
        transform: translateY(-2px);
        opacity: 0.9;
    }
    .vp-soc-fb { background: #1877f2; }
    .vp-soc-tw { background: #1da1f2; }
    .vp-soc-ig { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
    .vp-soc-yt { background: #ff0000; }

    /* Trust & Guarantee Box */
    .vp-guarantee-box {
        background: #f8fafc;
        border: 1px dashed var(--vp-slate-200);
        border-radius: var(--vp-radius-md);
        padding: 16px;
        margin-top: 18px;
    }
    .vp-guarantee-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--vp-slate-900);
        margin: 0 0 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .vp-guarantee-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: var(--vp-slate-600);
        margin-bottom: 6px;
    }
    .vp-guarantee-item:last-child {
        margin-bottom: 0;
    }
    .vp-guarantee-item i {
        color: var(--vp-success);
        font-size: 13px;
    }

    /* Form Inputs */
    .vp-form-control {
        width: 100%;
        padding: 12px 14px;
        border-radius: var(--vp-radius-sm);
        border: 1px solid var(--vp-slate-200);
        font-size: 14px;
        color: var(--vp-slate-800);
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }
    .vp-form-control:focus {
        border-color: var(--vp-primary);
        box-shadow: 0 0 0 3px rgba(193, 0, 55, 0.12);
    }

    /* Modal Tweaks */
    .modal-content {
        border-radius: var(--vp-radius-lg);
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }
    .modal-header {
        border-bottom: 1px solid var(--vp-slate-100);
        padding: 18px 24px;
    }
    .modal-body {
        padding: 24px;
    }
    .modal-footer {
        border-top: 1px solid var(--vp-slate-100);
        padding: 16px 24px;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .vp-author-flex {
            flex-direction: column;
            align-items: flex-start;
        }
        .vp-author-actions {
            width: 100%;
            justify-content: flex-start;
        }
        .vp-price-tag-hero {
            text-align: left;
            border-right: none;
            padding-right: 0;
            margin-bottom: 12px;
            width: 100%;
        }
        .vp-sidebar-sticky {
            position: static;
        }
    }
    @media (max-width: 576px) {
        .vp-author-card {
            padding: 20px 18px;
        }
        .vp-author-info {
            flex-direction: column;
            text-align: center;
        }
        .vp-badge-row, .vp-meta-chips {
            justify-content: center;
        }
        .vp-gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Working Hours Schedule Table */
    .vp-schedule-table {
        border: 1px solid var(--vp-slate-200);
        border-radius: var(--vp-radius-md);
        overflow: hidden;
        background: #ffffff;
    }
    .vp-schedule-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        border-bottom: 1px solid var(--vp-slate-100);
        font-size: 13.5px;
        transition: background 0.15s;
    }
    .vp-schedule-row:last-child {
        border-bottom: none;
    }
    .vp-schedule-row.is-today {
        background: #fff1f2;
        font-weight: 700;
        border-left: 3px solid #c10037;
    }
    .vp-schedule-day {
        color: var(--vp-slate-900);
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    .vp-schedule-time {
        color: var(--vp-slate-600);
        text-align: right;
    }

    /* Interactive Calendar Widget */
    .vp-cal-widget {
        background: #ffffff;
        border: 1px solid var(--vp-slate-200);
        border-radius: var(--vp-radius-md);
        padding: 18px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    .vp-cal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }
    .vp-cal-title {
        font-size: 15.5px;
        font-weight: 800;
        color: var(--vp-slate-900);
        letter-spacing: -0.01em;
    }
    .vp-cal-nav {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .vp-cal-btn {
        background: var(--vp-slate-100);
        border: 1px solid var(--vp-slate-200);
        color: var(--vp-slate-700);
        border-radius: 6px;
        padding: 4px 9px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
    }
    .vp-cal-btn:hover {
        background: var(--vp-slate-200);
        color: var(--vp-slate-900);
    }
    .vp-cal-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        text-align: center;
        font-size: 11.5px;
        font-weight: 700;
        color: var(--vp-slate-500);
        margin-bottom: 6px;
        text-transform: uppercase;
    }
    .vp-cal-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }
    .vp-cal-day {
        min-height: 38px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
        position: relative;
        border: 1px solid transparent;
        padding: 4px 2px;
    }
    .vp-cal-day.is-empty {
        cursor: default;
        background: transparent;
    }
    .vp-cal-day.is-past {
        color: #cbd5e1;
        cursor: not-allowed;
        background: #f8fafc;
    }
    .vp-cal-day.is-closed {
        color: #94a3b8;
        background: #f1f5f9;
        cursor: not-allowed;
        text-decoration: line-through;
    }
    .vp-cal-day.is-available {
        background: #f0fdf4;
        color: #166534;
        border-color: #bbf7d0;
    }
    .vp-cal-day.is-available:hover {
        background: #dcfce7;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(22, 101, 52, 0.15);
    }
    .vp-cal-day.is-today {
        box-shadow: inset 0 0 0 2px #c10037;
    }
    .vp-cal-day.is-selected {
        background: #c10037 !important;
        color: #ffffff !important;
        border-color: #c10037 !important;
        font-weight: 800;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(193, 0, 55, 0.35);
    }
    .vp-cal-dot {
        width: 4px;
        height: 4px;
        border-radius: 50%;
        margin-top: 2px;
    }
    .vp-cal-day.is-available .vp-cal-dot {
        background: #16a34a;
    }
    .vp-cal-day.is-selected .vp-cal-dot {
        background: #ffffff;
    }
    .vp-cal-legend {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid var(--vp-slate-100);
        font-size: 11px;
        color: var(--vp-slate-500);
        flex-wrap: wrap;
    }
    .vp-cal-legend-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .vp-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
    }
    .vp-dot-available { background: #16a34a; }
    .vp-dot-closed { background: #94a3b8; }
    .vp-dot-selected { background: #c10037; }
    .vp-cal-selected-strip {
        margin-top: 12px;
        padding: 10px 14px;
        border-radius: 8px;
        background: #fff1f2;
        border: 1px solid #fecdd3;
    }
</style>
@endsection

@section('content')
    <!-- Top Hero Banner with Breadcrumbs -->
    <div class="vp-hero-header">
        <div class="container position-relative" style="z-index: 2;">
            <ul class="vp-breadcrumb">
                <li><a href="/"><i class="feather-home me-1"></i> Home</a></li>
                <li class="separator"><i class="fas fa-chevron-right"></i></li>
                <li><a href="{{ route('search') }}">Verified Experts</a></li>
                <li class="separator"><i class="fas fa-chevron-right"></i></li>
                <li class="active">{{ $profile->vendor->name ?? $profile->vendor->username }}</li>
            </ul>
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-1 pb-2">
                <div>
                    <h2 class="text-white fw-bold mb-1" style="font-size: 26px; letter-spacing: -0.02em;">
                        {{ $profile->vendor->name ?? $profile->vendor->username }}
                    </h2>
                    <p class="mb-0 text-white-50 small">
                        <i class="fas fa-certificate text-warning me-1"></i> Certified {{ $profile->occupation->occupation_name ?? 'Service Provider' }} &bull; Available for on-demand bookings in {{ $profile->city->name ?? 'local area' }}
                    </p>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge py-2 px-3 fw-semibold text-white" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22); border-radius: 999px;">
                        <i class="fas fa-shield-alt text-success me-1"></i> 100% Verified Profile
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container Layout -->
    <div class="vp-profile-container">
        <div class="container">

            <!-- Author Hero Card -->
            <div class="vp-author-card">
                <div class="vp-author-flex">
                    <div class="vp-author-info">
                        <div class="vp-avatar-wrapper">
                            <img class="vp-avatar-img"
                                src="{{ asset('vendor/vendor_image/' . (!empty($profile->vendor->avatar) ? $profile->vendor->avatar : 'avatar.jpg')) }}"
                                onerror="this.onerror=null;this.src='{{ asset('vendor/vendor_image/avatar.jpg') }}';"
                                alt="{{ $profile->vendor->name ?? 'Vendor' }}">
                            <span class="vp-verified-badge" title="Verified Professional"><i class="fas fa-check"></i></span>
                        </div>
                        <div class="vp-author-meta">
                            <div class="vp-badge-row">
                                <span class="vp-badge vp-badge-occupation">
                                    <i class="fas fa-bolt"></i> {{ $profile->occupation->occupation_name ?? 'Professional' }}
                                </span>
                                <span class="vp-badge vp-badge-pro">
                                    <i class="fas fa-shield-alt"></i> Verified Pro
                                </span>
                            </div>
                            <h1>{{ $profile->vendor->name ?? $profile->vendor->username }}</h1>
                            <div class="vp-meta-chips">
                                <div class="vp-rating-pill">
                                    <i class="fas fa-star"></i>
                                    <span>{{ $profile->rating > 0 ? number_format($profile->rating, 1) : '5.0' }}</span>
                                    <span class="text-muted fw-normal">({{ $reviews->total() > 0 ? $reviews->total() : '1' }})</span>
                                </div>
                                <div class="vp-chip-item">
                                    <i class="feather-briefcase"></i>
                                    <span>{{ $profile->experience_year ?? '0' }} Y, {{ $profile->experience_month ?? '0' }} M Exp.</span>
                                </div>
                                @if(!empty($profile->city->name) || !empty($profile->state->name))
                                    <div class="vp-chip-item">
                                        <i class="feather-map-pin"></i>
                                        <span>{{ $profile->city->name ?? '' }}{{ !empty($profile->state->name) ? ', ' . $profile->state->name : '' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick CTA Cluster in Header for Instant Interaction -->
                    <div class="vp-author-actions">
                        @if ($profile->price_per_hour)
                            <div class="vp-price-tag-hero">
                                <div class="vp-price-amount">&#8377; {{ $profile->price_per_hour }}</div>
                                <span class="vp-price-unit">Per Hour / Visit</span>
                            </div>
                        @endif
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="vp-btn text-white btn-trigger-booking" data-toggle="modal" data-target="#bookingModal" data-bs-toggle="modal" data-bs-target="#bookingModal" style="width: auto; padding: 11px 20px; margin: 0; background: linear-gradient(135deg, #c10037 0%, #e11d48 100%); border: none; border-radius: 999px; font-weight: 700; box-shadow: 0 4px 14px rgba(193, 0, 55, 0.35);">
                                <i class="feather-calendar me-1"></i> Book Appointment
                            </button>
                            <a href="{{ route('chat.index', ['vendor_id' => $profile->vendor_id]) }}" class="vp-btn vp-btn-chat" style="width: auto; padding: 11px 18px; margin: 0;">
                                <i class="fas fa-comment-dots"></i> Live Chat
                            </a>
                            <button type="button" class="vp-btn vp-btn-message" data-toggle="modal" data-target="#exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal" style="width: auto; padding: 11px 18px; margin: 0;">
                                <i class="fa-regular fa-envelope"></i> Message
                            </button>
                            @if(!empty($profile->vendor->mobile))
                                <a href="tel:{{ $profile->vendor->mobile }}" class="vp-btn vp-btn-call" style="width: auto; padding: 11px 18px; margin: 0;">
                                    <i class="feather-phone"></i> Call Now
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Jump Anchor Bar -->
            <div class="vp-quick-nav">
                <ul class="vp-nav-links">
                    <li><a href="#about" class="vp-nav-link active"><i class="feather-user"></i> About</a></li>
                    <li><a href="#services" class="vp-nav-link"><i class="feather-check-circle"></i> Services</a></li>
                    <li><a href="#hours" class="vp-nav-link"><i class="feather-clock"></i> Working Hours & Calendar</a></li>
                    <li><a href="#gallery" class="vp-nav-link"><i class="feather-image"></i> Portfolio</a></li>
                    <li><a href="#reviews" class="vp-nav-link"><i class="feather-star"></i> Reviews ({{ $reviews->total() }})</a></li>
                </ul>
                <div class="d-none d-md-block text-muted small fw-semibold">
                    <i class="fas fa-shield-alt text-success me-1"></i> 100% Direct Connection & Zero Booking Fee
                </div>
            </div>

            <!-- 2-Column Professional Content Grid -->
            <div class="row">
                <!-- Left Column (68% - Main Detail Content) -->
                <div class="col-lg-8">
                    
                    <!-- 1. About / Description Card -->
                    <div class="vp-card" id="about">
                        <div class="vp-card-header">
                            <h2 class="vp-card-title">
                                <span class="vp-header-icon vp-icon-primary"><i class="feather-user"></i></span>
                                About the Professional
                            </h2>
                        </div>
                        <div class="vp-bio-content">
                            @if (!empty($profile->profile_description))
                                {!! strip_tags($profile->profile_description, '<p><br><strong><b><ul><ol><li><em>') !!}
                            @else
                                <p>Dedicated, certified {{ strtolower($profile->occupation->occupation_name ?? 'service provider') }} committed to top-tier service execution, transparent communication, and timely job completion for home and commercial projects.</p>
                            @endif
                        </div>
                        <div class="vp-trust-grid">
                            <div class="vp-trust-item">
                                <i class="fas fa-check-circle"></i> Identity Verified
                            </div>
                            <div class="vp-trust-item">
                                <i class="fas fa-clock"></i> Quick Response Time
                            </div>
                            <div class="vp-trust-item">
                                <i class="fas fa-award"></i> Quality Guaranteed
                            </div>
                            <div class="vp-trust-item">
                                <i class="fas fa-tag"></i> Fair & Direct Pricing
                            </div>
                        </div>
                    </div>

                    <!-- 2. Services Offered Card -->
                    <div class="vp-card" id="services">
                        <div class="vp-card-header">
                            <h2 class="vp-card-title">
                                <span class="vp-header-icon vp-icon-success"><i class="feather-check-circle"></i></span>
                                Services & Specialties
                            </h2>
                        </div>
                        @php
                            $serviceList = !empty($profile->services) ? array_filter(array_map('trim', explode(',', $profile->services))) : [];
                        @endphp
                        @if (!empty($serviceList))
                            <div class="vp-services-grid">
                                @foreach ($serviceList as $service)
                                    <div class="vp-service-chip">
                                        <i class="fas fa-check-circle"></i>
                                        <span>{{ ucfirst($service) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">General {{ $profile->occupation->occupation_name ?? 'expert' }} services, maintenance, installations, and repairs.</p>
                        @endif
                    </div>

                    <!-- 3. Working Hours & Availability Calendar Card -->
                    @php
                        $now = \Carbon\Carbon::now();
                        $currentDayOfWeek = $now->dayOfWeek; // 0 = Sunday, 1 = Monday, ...
                        $currentTimeStr = $now->format('H:i');
                        $isOpenNow = false;
                        $closingTime = null;
                        $weeklyData = [];

                        if (!empty($businessHour) && !empty($businessHour->weekly_hours)) {
                            $weeklyData = is_array($businessHour->weekly_hours) ? $businessHour->weekly_hours : json_decode($businessHour->weekly_hours, true);
                        }

                        if (empty($weeklyData)) {
                            $daysMap = [1=>'Monday', 2=>'Tuesday', 3=>'Wednesday', 4=>'Thursday', 5=>'Friday', 6=>'Saturday', 0=>'Sunday'];
                            foreach ($daysMap as $dow => $name) {
                                $weeklyData[] = [
                                    'day_of_week' => $dow,
                                    'label' => $name,
                                    'is_closed' => ($dow === 0),
                                    'slots' => ($dow === 0) ? [] : [['open' => '09:00', 'close' => '18:00']]
                                ];
                            }
                        }

                        foreach ($weeklyData as $dayItem) {
                            if (isset($dayItem['day_of_week']) && (int)$dayItem['day_of_week'] === $currentDayOfWeek) {
                                if (empty($dayItem['is_closed']) && !empty($dayItem['slots'])) {
                                    foreach ($dayItem['slots'] as $slot) {
                                        $openT = $slot['open_time'] ?? ($slot['open'] ?? '09:00');
                                        $closeT = $slot['close_time'] ?? ($slot['close'] ?? '18:00');
                                        if ($currentTimeStr >= $openT && $currentTimeStr <= $closeT) {
                                            $isOpenNow = true;
                                            $closingTime = $closeT;
                                            break;
                                        }
                                    }
                                }
                                break;
                            }
                        }
                    @endphp

                    <div class="vp-card" id="hours">
                        <div class="vp-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h2 class="vp-card-title mb-0">
                                <span class="vp-header-icon vp-icon-primary"><i class="feather-clock"></i></span>
                                Working Hours & Availability
                            </h2>
                            @if($isOpenNow)
                                <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-bold" style="font-size: 12px;">
                                    <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Open Now (until {{ \Carbon\Carbon::parse($closingTime)->format('h:i A') }})
                                </span>
                            @else
                                <span class="badge bg-secondary text-white px-3 py-2 rounded-pill fw-bold" style="font-size: 12px;">
                                    <i class="fas fa-clock me-1"></i> Currently Closed
                                </span>
                            @endif
                        </div>

                        <div class="row g-4">
                            <!-- Weekly Schedule Table -->
                            <div class="col-lg-5">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="fw-bold text-dark mb-0">
                                        <i class="feather-calendar text-primary me-1"></i> Weekly Hours
                                    </h6>
                                    <small class="text-muted">Standard Time</small>
                                </div>
                                
                                <div class="vp-schedule-table">
                                    @foreach($weeklyData as $wDay)
                                        @php
                                            $isToday = (isset($wDay['day_of_week']) && (int)$wDay['day_of_week'] === $currentDayOfWeek);
                                        @endphp
                                        <div class="vp-schedule-row {{ $isToday ? 'is-today' : '' }}">
                                            <div class="vp-schedule-day">
                                                <span>{{ $wDay['label'] ?? 'Day' }}</span>
                                                @if($isToday)
                                                    <span class="badge bg-primary text-white ms-2" style="font-size: 9.5px; padding: 2px 6px;">Today</span>
                                                @endif
                                            </div>
                                            <div class="vp-schedule-time">
                                                @if(!empty($wDay['is_closed']))
                                                    <span class="text-danger fw-semibold"><i class="feather-x-circle me-1 small"></i> Closed</span>
                                                @elseif(!empty($wDay['slots']) && count($wDay['slots']) > 0)
                                                    @foreach($wDay['slots'] as $slot)
                                                        @php
                                                            $op = $slot['open_time'] ?? ($slot['open'] ?? '09:00');
                                                            $cl = $slot['close_time'] ?? ($slot['close'] ?? '18:00');
                                                        @endphp
                                                        <div>
                                                            {{ \Carbon\Carbon::parse($op)->format('h:i A') }} - {{ \Carbon\Carbon::parse($cl)->format('h:i A') }}
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">By Appointment</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="p-3 mt-3 rounded-3" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                                    <div class="d-flex align-items-center gap-2 text-dark fw-bold small mb-1">
                                        <i class="feather-shield text-success"></i> Advance Online Booking
                                    </div>
                                    <p class="text-muted small mb-2">Book any upcoming open date with instant vendor confirmation.</p>
                                    <button type="button" class="btn btn-sm btn-primary w-100 fw-bold rounded-pill btn-trigger-booking" data-toggle="modal" data-target="#bookingModal" data-bs-toggle="modal" data-bs-target="#bookingModal" style="background:#c10037; border-color:#c10037;">
                                        <i class="feather-calendar me-1"></i> Book an Appointment
                                    </button>
                                </div>
                            </div>

                            <!-- Interactive Monthly Availability Calendar -->
                            <div class="col-lg-7">
                                <div class="vp-cal-widget">
                                    <div class="vp-cal-header">
                                        <div class="vp-cal-title" id="calMonthYearTitle">Loading Calendar...</div>
                                        <div class="vp-cal-nav">
                                            <button type="button" class="vp-cal-btn" id="calPrevBtn"><i class="fas fa-chevron-left"></i></button>
                                            <button type="button" class="vp-cal-btn" id="calTodayBtn">Today</button>
                                            <button type="button" class="vp-cal-btn" id="calNextBtn"><i class="fas fa-chevron-right"></i></button>
                                        </div>
                                    </div>

                                    <div class="vp-cal-weekdays">
                                        <div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
                                    </div>

                                    <div class="vp-cal-days" id="calDaysGrid">
                                        <!-- Rendered dynamically by JS -->
                                    </div>

                                    <div class="vp-cal-legend">
                                        <div class="vp-cal-legend-item">
                                            <span class="vp-dot vp-dot-available"></span> Available
                                        </div>
                                        <div class="vp-cal-legend-item">
                                            <span class="vp-dot vp-dot-closed"></span> Closed
                                        </div>
                                        <div class="vp-cal-legend-item">
                                            <span class="vp-dot vp-dot-selected"></span> Selected
                                        </div>
                                    </div>

                                    <!-- Selected Date Action Bar -->
                                    <div id="calSelectedStrip" class="vp-cal-selected-strip" style="display: none;">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <div>
                                                <span class="small text-muted d-block">Selected Date:</span>
                                                <span class="fw-bold text-dark" id="calSelectedDateText">--</span>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-primary fw-bold px-3 rounded-pill btn-trigger-booking" id="calBookSelectedBtn" data-toggle="modal" data-target="#bookingModal" data-bs-toggle="modal" data-bs-target="#bookingModal" style="background:#c10037; border-color:#c10037;">
                                                <i class="feather-calendar me-1"></i> Book This Date
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Work Gallery & Portfolio Card -->
                    <div class="vp-card" id="gallery">
                        <div class="vp-card-header">
                            <h2 class="vp-card-title">
                                <span class="vp-header-icon vp-icon-info"><i class="feather-image"></i></span>
                                Portfolio & Recent Work
                            </h2>
                            @if (!empty($profile->profileImage) && count($profile->profileImage) > 0)
                                <span class="badge bg-light text-dark fw-bold px-3 py-2 border rounded-pill">{{ count($profile->profileImage) }} Photos</span>
                            @endif
                        </div>
                        @if (!empty($profile->profileImage) && count($profile->profileImage) > 0)
                            <div class="vp-gallery-grid">
                                @foreach ($profile->profileImage as $key => $image)
                                    <a href="{{ asset('vendor/profile_image/' . $image->profile_image) }}"
                                       class="vp-gallery-card"
                                       data-fancybox="gallery"
                                       target="_blank">
                                        <img src="{{ asset('vendor/profile_image/' . $image->profile_image) }}"
                                             alt="Work Sample {{ $key + 1 }}"
                                             onerror="this.onerror=null;this.src='{{ asset('vendor/vendor_image/avatar.jpg') }}';"
                                             loading="lazy">
                                        <div class="vp-gallery-overlay">
                                            <i class="feather-zoom-in"></i>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="feather-image fa-2x mb-2 d-block text-slate-400"></i>
                                <span>No portfolio photos uploaded yet. Contact professional directly for project samples.</span>
                            </div>
                        @endif
                    </div>

                    <!-- 4. Reviews & Ratings Card -->
                    <div class="vp-card" id="reviews">
                        <div class="vp-card-header">
                            <h2 class="vp-card-title">
                                <span class="vp-header-icon vp-icon-warning"><i class="feather-star"></i></span>
                                Customer Reviews & Feedback
                            </h2>
                        </div>

                        <!-- Rating Overview Box -->
                        <div class="vp-reviews-summary">
                            <div>
                                <div class="vp-big-rating">{{ $profile->rating > 0 ? number_format($profile->rating, 1) : '5.0' }}</div>
                                <div class="vp-stars-display">
                                    @for ($r = 1; $r <= 5; $r++)
                                        @if ($r <= round($profile->rating > 0 ? $profile->rating : 5))
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <div class="border-start border-amber-300 ps-3">
                                <div class="fw-bold text-dark mb-1">Based on {{ $reviews->total() }} Verified Review{{ $reviews->total() == 1 ? '' : 's' }}</div>
                                <div class="text-muted small">Reviews are submitted by registered clients following service bookings.</div>
                            </div>
                        </div>

                        <!-- Existing Reviews List -->
                        <div class="mb-4">
                            @if (isset($reviews) && $reviews->count() > 0)
                                @foreach ($reviews as $review)
                                    <div class="vp-review-item">
                                        <div class="vp-reviewer-avatar">
                                            {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="vp-reviewer-header">
                                                <h4 class="vp-reviewer-name">{{ $review->user->name ?? 'Verified Client' }}</h4>
                                                <span class="vp-review-date"><i class="feather-calendar me-1"></i>{{ convertMdyToTimeAgo($review->updated_at) }}</span>
                                            </div>
                                            <div class="text-warning small mb-1">
                                                @for ($st = 1; $st <= 5; $st++)
                                                    @if ($st <= ($review->rating ?? 5))
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="vp-review-text">{{ $review->review }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="mt-3">
                                    {{ $reviews->links('pagination::bootstrap-5') }}
                                </div>
                            @else
                                <div class="text-center py-4 text-muted">
                                    <i class="feather-message-square fa-2x mb-2 d-block text-slate-400"></i>
                                    <span>No reviews submitted yet. Be the first to share your experience!</span>
                                </div>
                            @endif
                        </div>

                        <!-- Write a Review Form -->
                        <div class="p-3 bg-light rounded-3 border" id="review-section">
                            <h4 class="fw-bold text-dark fs-6 mb-2">
                                {{ isset($userReview) ? 'Edit Your Review' : 'Leave a Verified Review' }}
                            </h4>
                            <p class="text-muted small mb-3">Rate your experience with {{ $profile->vendor->name ?? $profile->vendor->username }}.</p>
                            
                            <form id="review-form">
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul class="mb-0 ps-3"></ul>
                                </div>
                                <div class="alert alert-success print-success-msg" style="display:none">
                                    <ul class="mb-0 ps-3"></ul>
                                </div>

                                <input type="hidden" id="profile_id" value="{{ $profile->id }}">
                                <input type="hidden" name="vendor_id" id="vendor_id" value="{{ $profile->vendor_id }}">

                                <div class="mb-2">
                                    <label class="form-label small fw-bold text-muted mb-1">Select Star Rating*</label>
                                    <div class="vp-star-rating-box">
                                        <input type="radio" id="star5" name="rating" value="5" {{ !empty($userReview->rating) && $userReview->rating == 5 ? 'checked' : '' }} />
                                        <label for="star5" title="5 Stars"></label>
                                        <input type="radio" id="star4" name="rating" value="4" {{ !empty($userReview->rating) && $userReview->rating == 4 ? 'checked' : '' }} />
                                        <label for="star4" title="4 Stars"></label>
                                        <input type="radio" id="star3" name="rating" value="3" {{ !empty($userReview->rating) && $userReview->rating == 3 ? 'checked' : '' }} />
                                        <label for="star3" title="3 Stars"></label>
                                        <input type="radio" id="star2" name="rating" value="2" {{ !empty($userReview->rating) && $userReview->rating == 2 ? 'checked' : '' }} />
                                        <label for="star2" title="2 Stars"></label>
                                        <input type="radio" id="star1" name="rating" value="1" {{ !empty($userReview->rating) && $userReview->rating == 1 ? 'checked' : '' }} />
                                        <label for="star1" title="1 Star"></label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="review" class="form-label small fw-bold text-muted mb-1">Your Detailed Feedback*</label>
                                    <textarea rows="4" class="vp-form-control" placeholder="Describe the service quality, punctuality, and professionalism..." name="review" id="review">{{ $userReview->review ?? '' }}</textarea>
                                </div>

                                <button class="btn btn-primary submit-btn px-4 py-2 fw-bold" type="submit" style="background:#c10037; border-color:#c10037; border-radius:8px;">
                                    <i class="fas fa-paper-plane me-1"></i> Submit Review
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

                <!-- Right Column (32% - Sticky Action & Contact Sidebar) -->
                <div class="col-lg-4">
                    <div class="vp-sidebar-sticky">

                        <!-- 1. Booking & Hire Card -->
                        <div class="vp-booking-card">
                            <div class="vp-booking-price-row">
                                <div>
                                    <div class="vp-price-large">&#8377; {{ $profile->price_per_hour ?? 'Negotiable' }}</div>
                                    <span class="vp-price-subtext">Estimated Per Hour or Visit</span>
                                </div>
                                <div>
                                    <span class="vp-avail-badge">
                                        <span class="vp-pulse-dot"></span> Available
                                    </span>
                                </div>
                            </div>

                            <!-- CTAs -->
                            <button type="button" class="vp-btn text-white w-100 mb-2 btn-trigger-booking" data-toggle="modal" data-target="#bookingModal" data-bs-toggle="modal" data-bs-target="#bookingModal" style="background: linear-gradient(135deg, #c10037 0%, #e11d48 100%); border: none; border-radius: 12px; font-weight: 700; padding: 13px; font-size: 15px; box-shadow: 0 6px 18px rgba(193, 0, 55, 0.3);">
                                <i class="feather-calendar me-2"></i> Book Appointment Now
                            </button>
                            <a href="{{ route('chat.index', ['vendor_id' => $profile->vendor_id]) }}" class="vp-btn vp-btn-chat">
                                <i class="fas fa-comment-dots"></i> Live Chat Now
                            </a>
                            <button type="button" class="vp-btn vp-btn-message" data-toggle="modal" data-target="#exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa-regular fa-envelope"></i> Send Direct Message
                            </button>
                            @if (!empty($profile->vendor->mobile))
                                <a href="tel:{{ $profile->vendor->mobile }}" class="vp-btn vp-btn-call">
                                    <i class="feather-phone"></i> Call {{ $profile->vendor->mobile }}
                                </a>
                            @endif

                            <div class="text-center text-muted small mt-2">
                                <i class="fas fa-shield-alt text-success me-1"></i> 100% Free Direct Booking & Contact
                            </div>
                        </div>

                        <!-- 2. Verified Contact Details Card -->
                        <div class="vp-card">
                            <div class="vp-card-header">
                                <h3 class="vp-card-title">
                                    <span class="vp-header-icon vp-icon-primary"><i class="feather-map-pin"></i></span>
                                    Contact & Location
                                </h3>
                            </div>

                            <ul class="vp-contact-list">
                                @php
                                    $fullAddress = trim(
                                        (!empty($profile->address) ? $profile->address . ', ' : '') .
                                        (!empty($profile->city->name) ? $profile->city->name . ', ' : '') .
                                        (!empty($profile->state->name) ? $profile->state->name . ', ' : '') .
                                        (!empty($profile->country->name) ? $profile->country->name . ' ' : '') .
                                        (!empty($profile->pincode) ? '- ' . $profile->pincode : '')
                                    );
                                @endphp
                                @if(!empty($fullAddress))
                                    <li class="vp-contact-row">
                                        <span class="vp-contact-icon"><i class="feather-map-pin"></i></span>
                                        <div>
                                            <span class="vp-contact-label">Service Address</span>
                                            <span class="text-dark fw-semibold">{{ $fullAddress }}</span>
                                        </div>
                                    </li>
                                @endif

                                @if (!empty($profile->vendor->mobile))
                                    <li class="vp-contact-row">
                                        <span class="vp-contact-icon"><i class="feather-phone"></i></span>
                                        <div>
                                            <span class="vp-contact-label">Phone Number</span>
                                            <a href="tel:{{ $profile->vendor->mobile }}">{{ $profile->vendor->mobile }}</a>
                                        </div>
                                    </li>
                                @endif

                                @if (!empty($profile->vendor->email))
                                    <li class="vp-contact-row">
                                        <span class="vp-contact-icon"><i class="feather-mail"></i></span>
                                        <div>
                                            <span class="vp-contact-label">Official Email</span>
                                            <a href="mailto:{{ $profile->vendor->email }}">{{ $profile->vendor->email }}</a>
                                        </div>
                                    </li>
                                @endif

                                @if (!empty($profile->website_url))
                                    <li class="vp-contact-row">
                                        <span class="vp-contact-icon"><i class="feather-globe"></i></span>
                                        <div>
                                            <span class="vp-contact-label">Website Portfolio</span>
                                            <a href="{{ $profile->website_url }}" target="_blank" rel="noopener noreferrer">Visit Website <i class="feather-external-link ms-1 small"></i></a>
                                        </div>
                                    </li>
                                @endif
                            </ul>

                            <!-- Social Profiles -->
                            @if (!empty($profile->vendor->facebook) || !empty($profile->vendor->instagram) || !empty($profile->vendor->twitter) || !empty($profile->vendor->youtube))
                                <div class="mt-3 pt-3 border-top">
                                    <span class="vp-contact-label mb-2">Connect On Social Media</span>
                                    <div class="vp-social-cluster">
                                        @if (!empty($profile->vendor->facebook))
                                            <a href="{{ $profile->vendor->facebook }}" target="_blank" class="vp-social-btn vp-soc-fb" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                        @endif
                                        @if (!empty($profile->vendor->twitter))
                                            <a href="{{ $profile->vendor->twitter }}" target="_blank" class="vp-social-btn vp-soc-tw" title="Twitter"><i class="fab fa-twitter"></i></a>
                                        @endif
                                        @if (!empty($profile->vendor->instagram))
                                            <a href="{{ $profile->vendor->instagram }}" target="_blank" class="vp-social-btn vp-soc-ig" title="Instagram"><i class="fab fa-instagram"></i></a>
                                        @endif
                                        @if (!empty($profile->vendor->youtube))
                                            <a href="{{ $profile->vendor->youtube }}" target="_blank" class="vp-social-btn vp-soc-yt" title="YouTube"><i class="fab fa-youtube"></i></a>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Trust Guarantee Checklist -->
                            <div class="vp-guarantee-box">
                                <div class="vp-guarantee-title">
                                    <i class="fas fa-check-shield text-success"></i> Why Hire via Eservice?
                                </div>
                                <div class="vp-guarantee-item">
                                    <i class="fas fa-check-circle"></i> Direct phone & chat connection
                                </div>
                                <div class="vp-guarantee-item">
                                    <i class="fas fa-check-circle"></i> No commission taken on your job
                                </div>
                                <div class="vp-guarantee-item">
                                    <i class="fas fa-check-circle"></i> Verified mobile & identity check
                                </div>
                                <div class="vp-guarantee-item">
                                    <i class="fas fa-check-circle"></i> Real reviews by real customers
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Quick Message Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0" id="exampleModalLabel">
                            <i class="feather-send text-primary me-1"></i> Send Quick Message
                        </h5>
                        <small class="text-muted">Direct notification to {{ $profile->vendor->name ?? $profile->vendor->username }}</small>
                    </div>
                    <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="alert alert-danger print-error-msg-modal m-3 mb-0" style="display:none">
                    <ul class="mb-0 ps-3"></ul>
                </div>
                <form id="message-form">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="vendor_id" value="{{ $profile->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="notification-name" class="form-label small fw-bold text-muted">Your Full Name*</label>
                            <input type="text" class="vp-form-control" id="notification-name" name="name" placeholder="e.g. John Doe" required>
                        </div>
                        <div class="mb-3">
                            <label for="notification-phone" class="form-label small fw-bold text-muted">Contact Phone Number*</label>
                            <input type="tel" class="vp-form-control" id="notification-phone" name="phone" placeholder="e.g. 9876543210" required>
                        </div>
                        <div class="mb-3">
                            <label for="notification-budget" class="form-label small fw-bold text-muted">Expected Budget (₹ Optional)</label>
                            <input type="text" class="vp-form-control" id="notification-budget" name="budget" placeholder="e.g. 500">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="form-label small fw-bold text-muted">Service Description / Requirement*</label>
                            <textarea class="vp-form-control" id="message-text" name="message" rows="3" placeholder="Tell the professional what you need done..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light fw-semibold" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-modal-submit fw-bold px-4" style="background:#c10037; border-color:#c10037;">
                            <i class="feather-send me-1"></i> Send Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Advance Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 20px 24px;">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="bookingModalLabel">
                            <i class="feather-calendar text-danger me-2"></i> Book Service Appointment
                        </h5>
                        <p class="text-white-50 small mb-0">
                            With <span class="text-white fw-semibold">{{ $profile->vendor->name ?? $profile->vendor->username }}</span> &bull; {{ $profile->occupation->occupation_name ?? 'Expert' }}
                        </p>
                    </div>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close" style="background: transparent; border: none; font-size: 28px; line-height: 1; opacity: 0.85; cursor: pointer;"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="alert alert-danger print-error-msg-booking m-3 mb-0" style="display:none">
                    <ul class="mb-0 ps-3"></ul>
                </div>

                <form id="advance-booking-form">
                    @csrf
                    <input type="hidden" name="vendor_id" value="{{ $profile->vendor_id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::id() ?? '' }}">
                    <input type="hidden" name="price" value="{{ $profile->price_per_hour ?? '' }}">

                    <div class="modal-body p-4">
                        <!-- Service Rate Banner -->
                        <div class="p-3 mb-4 rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 44px; height: 44px; border-radius: 10px; background: #fee2e2; color: #c10037; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                    <i class="feather-check-circle"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $profile->occupation->occupation_name ?? 'Verified Service' }}</h6>
                                    <small class="text-muted"><i class="feather-map-pin me-1"></i>{{ $profile->city->name ?? 'Local Service' }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="small text-muted">Estimated Price</div>
                                <div class="fw-bold text-dark" style="font-size: 18px; color: #c10037 !important;">
                                    ₹{{ $profile->price_per_hour ?? 'Negotiable' }}
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Booking Date -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">
                                    <i class="feather-calendar text-primary me-1"></i> Appointment Date*
                                </label>
                                <input type="date" class="form-control form-control-lg" id="modal_booking_date" name="booking_date" 
                                    min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required style="font-size: 14.5px; border-radius: 10px;">
                            </div>

                            <!-- Time Slot Selection -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">
                                    <i class="feather-clock text-primary me-1"></i> Available Time Slot*
                                </label>
                                <select class="form-select form-select-lg" id="modal_booking_slot" name="booking_time_slot" required style="font-size: 14.5px; border-radius: 10px;">
                                    <option value="">Loading slots...</option>
                                </select>
                                <small class="text-muted" id="slot-status-note">Dynamic real-time slots</small>
                            </div>

                            <!-- Customer Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">
                                    <i class="feather-user text-primary me-1"></i> Your Full Name*
                                </label>
                                <input type="text" class="form-control" name="customer_name" 
                                    value="{{ Auth::check() ? Auth::user()->name : '' }}" placeholder="e.g. John Doe" required style="border-radius: 10px; padding: 10px 14px;">
                            </div>

                            <!-- Contact Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">
                                    <i class="feather-phone text-primary me-1"></i> Phone / Mobile Number*
                                </label>
                                <input type="tel" class="form-control" name="customer_phone" 
                                    value="{{ Auth::check() ? (Auth::user()->mobile ?? Auth::user()->phone ?? '') : '' }}" placeholder="e.g. 9876543210" required style="border-radius: 10px; padding: 10px 14px;">
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">
                                    <i class="feather-mail text-primary me-1"></i> Email Address
                                </label>
                                <input type="email" class="form-control" name="customer_email" 
                                    value="{{ Auth::check() ? Auth::user()->email : '' }}" placeholder="e.g. name@example.com" style="border-radius: 10px; padding: 10px 14px;">
                            </div>

                            <!-- Service Need -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">
                                    <i class="feather-tag text-primary me-1"></i> Service Title / Need
                                </label>
                                <input type="text" class="form-control" name="service_title" 
                                    value="{{ $profile->occupation->occupation_name ?? 'Service Request' }}" placeholder="e.g. AC Repair, Electrical Wiring" style="border-radius: 10px; padding: 10px 14px;">
                            </div>

                            <!-- Service Address -->
                            <div class="col-12">
                                <label class="form-label fw-bold small text-dark">
                                    <i class="feather-map-pin text-primary me-1"></i> Complete Service Address*
                                </label>
                                <input type="text" class="form-control" name="booking_address" 
                                    placeholder="Flat / House No, Street, Landmark, Area, City, Pincode" required style="border-radius: 10px; padding: 10px 14px;">
                            </div>

                            <!-- Notes -->
                            <div class="col-12">
                                <label class="form-label fw-bold small text-dark">
                                    <i class="feather-file-text text-primary me-1"></i> Notes or Instructions (Optional)
                                </label>
                                <textarea class="form-control" name="notes" rows="2" 
                                    placeholder="Any specific requests, timing instructions or materials needed..." style="border-radius: 10px;"></textarea>
                            </div>
                        </div>

                        <div class="p-3 mt-3 rounded-3" style="background: #ecfdf5; border: 1px solid #a7f3d0;">
                            <div class="d-flex align-items-center gap-2 text-success small fw-semibold">
                                <i class="fas fa-shield-alt"></i> Direct vendor confirmation &bull; No upfront card payment &bull; Pay vendor after job completion.
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="btn-submit-booking" class="btn btn-primary rounded-pill px-4 fw-bold" style="background: #c10037; border-color: #c10037;">
                            <i class="feather-check-circle me-1"></i> Confirm Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <script>
        $(function() {
            // Smooth scroll for in-page anchors
            $(".vp-nav-link").on("click", function(e) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    e.preventDefault();
                    $(".vp-nav-link").removeClass("active");
                    $(this).addClass("active");
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 95
                    }, 500);
                }
            });

            // Initialize fancybox
            if ($.fn.fancybox) {
                $('[data-fancybox="gallery"]').fancybox({
                    buttons: ["zoom", "close"],
                    loop: true,
                    protect: true
                });
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Submit Review AJAX
            $(".submit-btn").click(function(e) {
                e.preventDefault();
                var $btn = $(this);
                $(".print-error-msg").css('display', 'none');
                $(".print-success-msg").css('display', 'none');

                var review = $("#review").val();
                var rating = $('input[name="rating"]:checked').val();
                var profile_id = $("#profile_id").val();
                var vendor_id = $("#vendor_id").val();

                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Submitting...');

                $.ajax({
                    url: "{{ url('create-review') }}",
                    type: 'POST',
                    data: {
                        review: review,
                        rating: rating,
                        profile_id: profile_id,
                        vendor_id: vendor_id
                    },
                    success: function(data) {
                        $btn.prop('disabled', false).html('<i class="fas fa-paper-plane me-1"></i> Submit Review');
                        if ($.isEmptyObject(data.error)) {
                            $("#review-form")[0].reset();
                            swal({
                                title: "Feedback Recorded!",
                                text: "Thank you for sharing your review and rating.",
                                icon: "success"
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            printErrorMsg(data.error);
                        }
                    },
                    error: function() {
                        $btn.prop('disabled', false).html('<i class="fas fa-paper-plane me-1"></i> Submit Review');
                        printErrorMsg(['Something went wrong. Please check that you are logged in.']);
                    }
                });
            });

            // Submit Message Modal AJAX
            $(".btn-modal-submit").click(function(e) {
                e.preventDefault();
                var $btn = $(this);
                var _token = $("input[name='_token']").val();
                var name = $("#notification-name").val();
                var phone = $("#notification-phone").val();
                var budget = $("#notification-budget").val();
                var message = $("#message-text").val();
                var user_id = $("input[name='user_id']").val();
                var vendor_id = $("input[name='vendor_id']").val();

                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Sending...');

                $.ajax({
                    url: "{{ route('notification.store') }}",
                    type: 'POST',
                    data: {
                        _token: _token,
                        name: name,
                        phone: phone,
                        message: message,
                        budget: budget,
                        user_id: user_id,
                        vendor_id: vendor_id
                    },
                    success: function(data) {
                        $btn.prop('disabled', false).html('<i class="feather-send me-1"></i> Send Request');
                        if ($.isEmptyObject(data.error)) {
                            $("#message-form")[0].reset();
                            $('#exampleModal').modal('hide');
                            swal({
                                title: "Message Sent!",
                                text: "Your request has been delivered to the professional successfully.",
                                icon: "success"
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            printErrorMsgModal(data.error);
                        }
                    },
                    error: function() {
                        $btn.prop('disabled', false).html('<i class="feather-send me-1"></i> Send Request');
                        printErrorMsgModal(['Unable to send message right now. Please try calling directly.']);
                    }
                });
            });

            function printErrorMsgModal(msg) {
                var $box = $(".print-error-msg-modal");
                $box.find("ul").html('');
                $box.css('display', 'block');
                $.each(msg, function(key, value) {
                    $box.find("ul").append('<li>' + value + '</li>');
                });
            }

            function printErrorMsg(msg) {
                var $box = $(".print-error-msg");
                $box.find("ul").html('');
                $box.css('display', 'block');
                $.each(msg, function(key, value) {
                    $box.find("ul").append('<li>' + value + '</li>');
                });
            }

            // ============================================
            // INTERACTIVE CALENDAR & ADVANCE BOOKING MODULE
            // ============================================
            var vendorId = {{ $profile->vendor_id }};
            var weeklyHoursData = @json($weeklyData);
            var specialDatesData = @json($businessHour->special_dates ?? []);

            var today = new Date();
            var calYear = today.getFullYear();
            var calMonth = today.getMonth(); // 0-indexed
            var selectedDateStr = null;

            var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            function padZero(num) {
                return num < 10 ? '0' + num : num;
            }

            function isVendorOpenOnDay(dayOfWeek, dateStr) {
                // Check special dates first
                if (Array.isArray(specialDatesData)) {
                    for (var i = 0; i < specialDatesData.length; i++) {
                        var sp = specialDatesData[i];
                        if (sp.from_date && sp.to_date && dateStr >= sp.from_date && dateStr <= sp.to_date) {
                            if (sp.is_closed) return false;
                            if (sp.slots && sp.slots.length > 0) return true;
                        }
                    }
                }

                // Check weekly hours
                if (Array.isArray(weeklyHoursData)) {
                    for (var j = 0; j < weeklyHoursData.length; j++) {
                        var item = weeklyHoursData[j];
                        if (parseInt(item.day_of_week) === dayOfWeek) {
                            if (item.is_closed) return false;
                            if (item.slots && item.slots.length > 0) return true;
                        }
                    }
                }
                return true; // Default available
            }

            function renderCalendar(year, month) {
                $("#calMonthYearTitle").text(monthNames[month] + " " + year);
                var $grid = $("#calDaysGrid");
                $grid.empty();

                var firstDayIndex = new Date(year, month, 1).getDay(); // 0 = Sunday
                var totalDays = new Date(year, month + 1, 0).getDate();

                var todayY = today.getFullYear();
                var todayM = today.getMonth();
                var todayD = today.getDate();
                var todayDateStr = todayY + '-' + padZero(todayM + 1) + '-' + padZero(todayD);

                // Add empty blanks before 1st of month
                for (var b = 0; b < firstDayIndex; b++) {
                    $grid.append('<div class="vp-cal-day is-empty"></div>');
                }

                // Add days
                for (var d = 1; d <= totalDays; d++) {
                    var cellDate = new Date(year, month, d);
                    var cellDayOfWeek = cellDate.getDay();
                    var cellDateStr = year + '-' + padZero(month + 1) + '-' + padZero(d);

                    var isPast = cellDateStr < todayDateStr;
                    var isToday = (year === todayY && month === todayM && d === todayD);
                    var isOpen = isVendorOpenOnDay(cellDayOfWeek, cellDateStr);

                    var classes = ['vp-cal-day'];
                    if (isToday) classes.push('is-today');

                    if (isPast) {
                        classes.push('is-past');
                    } else if (!isOpen) {
                        classes.push('is-closed');
                    } else {
                        classes.push('is-available');
                    }

                    if (selectedDateStr === cellDateStr) {
                        classes.push('is-selected');
                    }

                    var $dayCell = $('<div class="' + classes.join(' ') + '" data-date="' + cellDateStr + '">' +
                        '<span>' + d + '</span>' +
                        (!isPast && isOpen ? '<span class="vp-cal-dot"></span>' : '') +
                        '</div>');

                    if (!isPast && isOpen) {
                        $dayCell.on('click', function() {
                            var clickedDate = $(this).attr('data-date');
                            selectDate(clickedDate);
                        });
                    }

                    $grid.append($dayCell);
                }
            }

            function selectDate(dateStr) {
                selectedDateStr = dateStr;
                $(".vp-cal-day").removeClass('is-selected');
                $('.vp-cal-day[data-date="' + dateStr + '"]').addClass('is-selected');

                var parts = dateStr.split('-');
                var dObj = new Date(parts[0], parseInt(parts[1]) - 1, parts[2]);
                var formattedNice = dObj.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });

                $("#calSelectedDateText").text(formattedNice);
                $("#calSelectedStrip").fadeIn();

                // Sync modal date input and load slots
                $("#modal_booking_date").val(dateStr);
                loadSlotsForDate(dateStr);
            }

            $("#calPrevBtn").on('click', function() {
                calMonth--;
                if (calMonth < 0) {
                    calMonth = 11;
                    calYear--;
                }
                renderCalendar(calYear, calMonth);
            });

            $("#calNextBtn").on('click', function() {
                calMonth++;
                if (calMonth > 11) {
                    calMonth = 0;
                    calYear++;
                }
                renderCalendar(calYear, calMonth);
            });

            $("#calTodayBtn").on('click', function() {
                calYear = today.getFullYear();
                calMonth = today.getMonth();
                renderCalendar(calYear, calMonth);
            });

            // Initial render
            renderCalendar(calYear, calMonth);

            // Dynamic slot loader from server
            function loadSlotsForDate(dateVal) {
                if (!dateVal) return;
                var $slotSelect = $("#modal_booking_slot");
                var $note = $("#slot-status-note");
                var $submitBtn = $("#btn-submit-booking");

                $slotSelect.prop('disabled', true).html('<option value="">Fetching available slots...</option>');
                $note.html('<i class="fas fa-spinner fa-spin me-1"></i> Checking schedule...');

                $.ajax({
                    url: "{{ url('/vendor-available-slots') }}/" + vendorId + "/" + dateVal,
                    type: "GET",
                    dataType: "json",
                    success: function(resp) {
                        $slotSelect.prop('disabled', false).empty();
                        if (resp.is_closed) {
                            $slotSelect.append('<option value="">Vendor is unavailable / closed on this date</option>');
                            $note.html('<span class="text-danger fw-bold"><i class="feather-alert-triangle me-1"></i> ' + (resp.reason || 'Closed on this day') + '</span>');
                            $submitBtn.prop('disabled', true);
                        } else if (resp.slots && resp.slots.length > 0) {
                            $slotSelect.append('<option value="">-- Choose a convenient time slot --</option>');
                            $.each(resp.slots, function(idx, slot) {
                                $slotSelect.append('<option value="' + slot + '">' + slot + '</option>');
                            });
                            $note.html('<span class="text-success fw-bold"><i class="feather-check-circle me-1"></i> ' + resp.slots.length + ' available time slots</span>');
                            $submitBtn.prop('disabled', false);
                        } else {
                            $slotSelect.append('<option value="Standard Daytime Visit (09:00 AM - 05:00 PM)">Standard Daytime Visit (09:00 AM - 05:00 PM)</option>');
                            $note.html('<span class="text-success"><i class="feather-check-circle me-1"></i> Open for flexible booking</span>');
                            $submitBtn.prop('disabled', false);
                        }
                    },
                    error: function() {
                        $slotSelect.prop('disabled', false).html('<option value="Standard Daytime Visit">Standard Daytime Visit</option>');
                        $note.text('Default daytime hours');
                        $submitBtn.prop('disabled', false);
                    }
                });
            }

            // On modal date change
            $("#modal_booking_date").on('change', function() {
                var dVal = $(this).val();
                loadSlotsForDate(dVal);
            });

            // Initial slot load for modal default date
            var initialDate = $("#modal_booking_date").val();
            if (initialDate) {
                loadSlotsForDate(initialDate);
            }

            // Modal show trigger for all booking buttons
            $(document).on('click', '.btn-trigger-booking, [data-target="#bookingModal"], [data-bs-target="#bookingModal"]', function(e) {
                e.preventDefault();
                $('#bookingModal').modal('show');
            });

            // Advance Booking Form Submit AJAX
            $("#advance-booking-form").on('submit', function(e) {
                e.preventDefault();
                var $btn = $("#btn-submit-booking");
                var $errorBox = $(".print-error-msg-booking");
                $errorBox.hide().find("ul").empty();

                var slotVal = $("#modal_booking_slot").val();
                if (!slotVal) {
                    $errorBox.show().find("ul").html('<li>Please choose a time slot.</li>');
                    return;
                }

                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Confirming...');

                $.ajax({
                    url: "{{ route('booking.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(resp) {
                        $btn.prop('disabled', false).html('<i class="feather-check-circle me-1"></i> Confirm Appointment');
                        if (resp.success) {
                            $("#advance-booking-form")[0].reset();
                            $('#bookingModal').modal('hide');
                            swal({
                                title: "Appointment Requested!",
                                text: "Booking Reference: " + resp.reference + "\n\nThe vendor has been notified and will confirm your booking shortly.",
                                icon: "success",
                                button: "Understood"
                            }).then(function() {
                                location.reload();
                            });
                        } else if (resp.error) {
                            $errorBox.show();
                            $.each(resp.error, function(k, v) {
                                $errorBox.find("ul").append('<li>' + v + '</li>');
                            });
                        }
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).html('<i class="feather-check-circle me-1"></i> Confirm Appointment');
                        $errorBox.show();
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            $.each(xhr.responseJSON.error, function(k, v) {
                                $errorBox.find("ul").append('<li>' + v + '</li>');
                            });
                        } else {
                            $errorBox.find("ul").append('<li>Unable to complete booking. Please try again or contact the vendor directly.</li>');
                        }
                    }
                });
            });
        });
    </script>
@endpush
