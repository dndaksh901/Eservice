@extends('layouts.main')


@section('content')
<style>
    .breadcrumb-bar {
        display: none !important;
    }
    .dashboard-content {
        padding: 120px 0 70px !important;
    }
    .invalid-feedback {
        position: relative;
    }
</style>

    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">Business Hours</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Business Hours</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="container">
            <div class="">
                @include('includes.tabs')
            </div>
            <div class="profile-content">
                <div class="row dashboard-info">
                    <div class="col-lg-9">
                        @if(session()->has('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ url('vendor/business-hours') }}" method="post" class="forms-sample">
                            @csrf
                            <div class="card dash-cards">
                                <div class="card-header">
                                    <h4>Weekly Business Hours</h4>
                                    <p class="text-muted">By default this is 24/7. You can customize schedule by day.</p>
                                </div>
                                <div class="card-body">
                                    <div class="weekly-schedule">
                                        @foreach($weekly as $day)
                                            <div class="card mb-4 weekly-day" data-day="{{ $day['day_of_week'] }}">
                                                <div class="card-body">
                                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
                                                        <div>
                                                            <h5 class="mb-1">{{ $day['label'] }}</h5>
                                                            <p class="text-muted mb-0">Add one or more responsive time slots for this day.</p>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="form-check mb-0">
                                                                <input type="hidden" name="weekly[{{ $day['day_of_week'] }}][is_closed]" value="0">
                                                                <input type="checkbox" class="form-check-input weekly-closed" data-day="{{ $day['day_of_week'] }}" name="weekly[{{ $day['day_of_week'] }}][is_closed]" value="1" {{ $day['is_closed'] ? 'checked' : '' }}>
                                                                <label class="form-check-label">Closed</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="weekly-slots" id="weekly-slots-{{ $day['day_of_week'] }}">
                                                        @foreach($day['slots'] as $slotIndex => $slot)
                                                            <div class="row g-2 align-items-end mb-3 weekly-slot-row" data-slot-index="{{ $slotIndex }}">
                                                                <div class="col-12 col-sm-6 col-lg-3">
                                                                    <label class="form-label">Open</label>
                                                                    <input type="time" class="form-control @error('weekly.' . $day['day_of_week'] . '.slots.' . $slotIndex . '.open_time') is-invalid @enderror" name="weekly[{{ $day['day_of_week'] }}][slots][{{ $slotIndex }}][open_time]" value="{{ old('weekly.' . $day['day_of_week'] . '.slots.' . $slotIndex . '.open_time', $slot['open_time']) }}" {{ $day['is_closed'] ? 'disabled' : '' }}>
                                                                    @error('weekly.' . $day['day_of_week'] . '.slots.' . $slotIndex . '.open_time')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-12 col-sm-6 col-lg-3">
                                                                    <label class="form-label">Close</label>
                                                                    <input type="time" class="form-control @error('weekly.' . $day['day_of_week'] . '.slots.' . $slotIndex . '.close_time') is-invalid @enderror" name="weekly[{{ $day['day_of_week'] }}][slots][{{ $slotIndex }}][close_time]" value="{{ old('weekly.' . $day['day_of_week'] . '.slots.' . $slotIndex . '.close_time', $slot['close_time']) }}" {{ $day['is_closed'] ? 'disabled' : '' }}>
                                                                    @error('weekly.' . $day['day_of_week'] . '.slots.' . $slotIndex . '.close_time')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-12 col-sm-6 col-lg-3">
                                                                    <label class="form-label">Capacity</label>
                                                                    <input type="number" min="1" class="form-control" name="weekly[{{ $day['day_of_week'] }}][slots][{{ $slotIndex }}][capacity]" value="{{ old('weekly.' . $day['day_of_week'] . '.slots.' . $slotIndex . '.capacity', $slot['capacity'] ?? 1) }}" {{ $day['is_closed'] ? 'disabled' : '' }}>
                                                                </div>
                                                                <div class="col-12 col-sm-6 col-lg-3 d-grid">
                                                                    <button type="button" class="btn btn-outline-danger remove-weekly-slot">Remove</button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn btn-sm btn-primary add-weekly-slot" data-day="{{ $day['day_of_week'] }}">Add time slot</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group mt-4">
                                        <button type="button" id="reset-24-hours" class="btn btn-sm btn-secondary">Reset to 24/7</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card dash-cards mt-4">
                                <div class="card-header">
                                    <h4>Special Dates</h4>
                                    <p class="text-muted">Add specific date overrides. Mark a date closed or set custom open/close hours.</p>
                                </div>
                                <div class="card-body">
                                    <div id="special-dates">
                                        @forelse($specialDates as $index => $special)
                                            <div class="card mb-3 special-date-row" data-index="{{ $index }}">
                                                <div class="card-body">
                                                    <div class="row gy-3 align-items-end mb-3">
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">From</label>
                                                            <input type="date" class="form-control @error('special.' . $index . '.from_date') is-invalid @enderror" name="special[{{ $index }}][from_date]" value="{{ old('special.' . $index . '.from_date', $special['from_date']) }}">
                                                            @error('special.' . $index . '.from_date')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">To</label>
                                                            <input type="date" class="form-control @error('special.' . $index . '.to_date') is-invalid @enderror" name="special[{{ $index }}][to_date]" value="{{ old('special.' . $index . '.to_date', $special['to_date']) }}">
                                                            @error('special.' . $index . '.to_date')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row gy-3 align-items-end mb-3">
                                                        <div class="col-12 col-md-5 d-flex align-items-center">
                                                            <input type="hidden" name="special[{{ $index }}][is_closed]" value="0">
                                                            <div class="form-check mb-0">
                                                                <input type="checkbox" class="form-check-input special-closed" data-index="{{ $index }}" name="special[{{ $index }}][is_closed]" value="1" {{ $special['is_closed'] ? 'checked' : '' }}>
                                                                <label class="form-check-label">Closed</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-3 d-grid">
                                                            <button type="button" class="btn btn-outline-danger remove-special-date">Remove</button>
                                                        </div>
                                                    </div>

                                                    <div class="special-slots" id="special-slots-{{ $index }}">
                                                        @foreach($special['slots'] as $slotIndex => $slot)
                                                            <div class="row g-2 align-items-end mb-3 special-slot-row" data-slot-index="{{ $slotIndex }}">
                                                                <div class="col-12 col-sm-6 col-lg-3">
                                                                    <label class="form-label">Open</label>
                                                                    <input type="time" class="form-control @error('special.' . $index . '.slots.' . $slotIndex . '.open_time') is-invalid @enderror" name="special[{{ $index }}][slots][{{ $slotIndex }}][open_time]" value="{{ old('special.' . $index . '.slots.' . $slotIndex . '.open_time', $slot['open_time']) }}" {{ $special['is_closed'] ? 'disabled' : '' }}>
                                                                    @error('special.' . $index . '.slots.' . $slotIndex . '.open_time')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-12 col-sm-6 col-lg-3">
                                                                    <label class="form-label">Close</label>
                                                                    <input type="time" class="form-control @error('special.' . $index . '.slots.' . $slotIndex . '.close_time') is-invalid @enderror" name="special[{{ $index }}][slots][{{ $slotIndex }}][close_time]" value="{{ old('special.' . $index . '.slots.' . $slotIndex . '.close_time', $slot['close_time']) }}" {{ $special['is_closed'] ? 'disabled' : '' }}>
                                                                    @error('special.' . $index . '.slots.' . $slotIndex . '.close_time')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-12 col-sm-6 col-lg-3">
                                                                    <label class="form-label">Capacity</label>
                                                                    <input type="number" min="1" class="form-control" name="special[{{ $index }}][slots][{{ $slotIndex }}][capacity]" value="{{ old('special.' . $index . '.slots.' . $slotIndex . '.capacity', $slot['capacity'] ?? 1) }}" {{ $special['is_closed'] ? 'disabled' : '' }}>
                                                                </div>
                                                                <div class="col-12 col-sm-6 col-lg-3 d-grid">
                                                                    <button type="button" class="btn btn-outline-danger remove-special-slot">Remove</button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn btn-sm btn-primary add-special-slot" data-index="{{ $index }}">Add slot</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="card mb-3 special-date-row" data-index="0">
                                                <div class="card-body">
                                                    <div class="row gy-3 align-items-end mb-3">
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">From</label>
                                                            <input type="date" class="form-control" name="special[0][from_date]">
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">To</label>
                                                            <input type="date" class="form-control" name="special[0][to_date]">
                                                        </div>
                                                    </div>
                                                    <div class="row gy-3 align-items-end mb-3">
                                                        <div class="col-12 col-md-5 d-flex align-items-center">
                                                            <input type="hidden" name="special[0][is_closed]" value="0">
                                                            <div class="form-check mb-0">
                                                                <input type="checkbox" class="form-check-input special-closed" data-index="0" name="special[0][is_closed]" value="1">
                                                                <label class="form-check-label">Closed</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-3 d-grid">
                                                            <button type="button" class="btn btn-outline-danger remove-special-date">Remove</button>
                                                        </div>
                                                    </div>

                                                    <div class="special-slots" id="special-slots-0">
                                                        <div class="row g-2 align-items-end special-slot-row" data-slot-index="0">
                                                            <div class="col-12 col-sm-6 col-lg-3">
                                                                <label class="form-label">Open</label>
                                                                <input type="time" class="form-control" name="special[0][slots][0][open_time]" value="09:00">
                                                            </div>
                                                            <div class="col-12 col-sm-6 col-lg-3">
                                                                <label class="form-label">Close</label>
                                                                <input type="time" class="form-control" name="special[0][slots][0][close_time]" value="18:00">
                                                            </div>
                                                            <div class="col-12 col-sm-6 col-lg-3">
                                                                <label class="form-label">Capacity</label>
                                                                <input type="number" min="1" class="form-control" name="special[0][slots][0][capacity]" value="1">
                                                            </div>
                                                            <div class="col-12 col-sm-6 col-lg-3 d-grid">
                                                                <button type="button" class="btn btn-outline-danger remove-special-slot">Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn btn-sm btn-primary add-special-slot" data-index="0">Add slot</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>

                                    <button type="button" id="add-special-date" class="btn btn-sm btn-primary">Add special date</button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4">Save Business Hours</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    function toggleWeeklyInputs(day) {
        var row = document.querySelector('[data-day="' + day + '"]');
        if (!row) return;
        var checked = row.querySelector('.weekly-closed').checked;
        row.querySelectorAll('.weekly-slot-row input').forEach(function (input) {
            input.disabled = checked;
        });
    }

    function toggleSpecialInputs(index) {
        var row = document.querySelector('[data-index="' + index + '"]');
        if (!row) return;
        var checked = row.querySelector('.special-closed').checked;
        row.querySelectorAll('.special-slot-row input').forEach(function (input) {
            input.disabled = checked;
        });
    }

    function addWeeklySlot(day) {
        var container = document.getElementById('weekly-slots-' + day);
        var slotIndex = container.querySelectorAll('.weekly-slot-row').length;
        var row = document.createElement('div');
        row.className = 'row align-items-end mb-2 weekly-slot-row';
        row.dataset.slotIndex = slotIndex;
        row.innerHTML = `
            <div class="col-md-3">
                <label>Open</label>
                <input type="time" class="form-control" name="weekly[${day}][slots][${slotIndex}][open_time]" value="09:00">
            </div>
            <div class="col-md-3">
                <label>Close</label>
                <input type="time" class="form-control" name="weekly[${day}][slots][${slotIndex}][close_time]" value="18:00">
            </div>
            <div class="col-md-3">
                <label>Capacity</label>
                <input type="number" min="1" class="form-control" name="weekly[${day}][slots][${slotIndex}][capacity]" value="1">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-weekly-slot mt-4">Remove</button>
            </div>
        `;
        container.appendChild(row);
        row.querySelector('.remove-weekly-slot').addEventListener('click', function () {
            row.remove();
        });
    }

    function addSpecialSlot(index) {
        var container = document.getElementById('special-slots-' + index);
        var slotIndex = container.querySelectorAll('.special-slot-row').length;
        var row = document.createElement('div');
        row.className = 'row align-items-end mb-2 special-slot-row';
        row.dataset.slotIndex = slotIndex;
        row.innerHTML = `
            <div class="col-md-3">
                <label>Open</label>
                <input type="time" class="form-control" name="special[${index}][slots][${slotIndex}][open_time]" value="09:00">
            </div>
            <div class="col-md-3">
                <label>Close</label>
                <input type="time" class="form-control" name="special[${index}][slots][${slotIndex}][close_time]" value="18:00">
            </div>
            <div class="col-md-3">
                <label>Capacity</label>
                <input type="number" min="1" class="form-control" name="special[${index}][slots][${slotIndex}][capacity]" value="1">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-special-slot mt-4">Remove</button>
            </div>
        `;
        container.appendChild(row);
        row.querySelector('.remove-special-slot').addEventListener('click', function () {
            row.remove();
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.weekly-closed').forEach(function (checkbox) {
            toggleWeeklyInputs(checkbox.dataset.day);
            checkbox.addEventListener('change', function () {
                toggleWeeklyInputs(this.dataset.day);
            });
        });

        document.querySelectorAll('.special-closed').forEach(function (checkbox) {
            toggleSpecialInputs(checkbox.dataset.index);
            checkbox.addEventListener('change', function () {
                toggleSpecialInputs(this.dataset.index);
            });
        });

        document.querySelectorAll('.add-weekly-slot').forEach(function (button) {
            button.addEventListener('click', function () {
                addWeeklySlot(this.dataset.day);
            });
        });

        document.querySelectorAll('.add-special-slot').forEach(function (button) {
            button.addEventListener('click', function () {
                addSpecialSlot(this.dataset.index);
            });
        });

        document.querySelectorAll('.remove-weekly-slot').forEach(function (button) {
            button.addEventListener('click', function () {
                this.closest('.weekly-slot-row').remove();
            });
        });

        document.querySelectorAll('.remove-special-slot').forEach(function (button) {
            button.addEventListener('click', function () {
                this.closest('.special-slot-row').remove();
            });
        });

        document.getElementById('add-special-date').addEventListener('click', function () {
            var container = document.getElementById('special-dates');
            var existing = Array.from(container.querySelectorAll('.special-date-row'));
            var index = existing.reduce(function (max, row) {
                var value = parseInt(row.dataset.index, 10);
                return isNaN(value) ? max : Math.max(max, value);
            }, -1) + 1;
            var template = `
                <div class="card shadow-sm mb-3 special-date-row" data-index="${index}">
                    <div class="card-body">
                        <div class="row gy-3 align-items-end mb-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">From</label>
                                <input type="date" class="form-control" name="special[${index}][from_date]">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">To</label>
                                <input type="date" class="form-control" name="special[${index}][to_date]">
                            </div>
                        </div>
                        <div class="row gy-3 align-items-end mb-3">
                            <div class="col-12 col-md-5 d-flex align-items-center">
                                <input type="hidden" name="special[${index}][is_closed]" value="0">
                                <div class="form-check mb-0">
                                    <input type="checkbox" class="form-check-input special-closed" data-index="${index}" name="special[${index}][is_closed]" value="1">
                                    <label class="form-check-label">Closed</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 d-grid">
                                <button type="button" class="btn btn-danger btn-sm remove-special-date">Remove</button>
                            </div>
                        </div>
                        <div class="special-slots" id="special-slots-${index}">
                            <div class="row g-2 align-items-end mb-2 special-slot-row" data-slot-index="0">
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label class="form-label">Open</label>
                                    <input type="time" class="form-control" name="special[${index}][slots][0][open_time]" value="09:00">
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label class="form-label">Close</label>
                                    <input type="time" class="form-control" name="special[${index}][slots][0][close_time]" value="18:00">
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label class="form-label">Capacity</label>
                                    <input type="number" min="1" class="form-control" name="special[${index}][slots][0][capacity]" value="1">
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3 d-grid">
                                    <button type="button" class="btn btn-danger btn-sm remove-special-slot">Remove</button>
                                </div>
                            </div>
                        </div>
                    <button type="button" class="btn btn-sm btn-primary add-special-slot" data-index="${index}">Add slot</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
            container.querySelector('[data-index="' + index + '"] .special-closed').addEventListener('change', function () {
                toggleSpecialInputs(this.dataset.index);
            });
            container.querySelector('[data-index="' + index + '"] .remove-special-date').addEventListener('click', function () {
                this.closest('.special-date-row').remove();
            });
            container.querySelector('[data-index="' + index + '"] .add-special-slot').addEventListener('click', function () {
                addSpecialSlot(this.dataset.index);
            });
            container.querySelector('[data-index="' + index + '"] .remove-special-slot').addEventListener('click', function () {
                this.closest('.special-slot-row').remove();
            });
        });

        document.querySelectorAll('.remove-special-date').forEach(function (button) {
            button.addEventListener('click', function () {
                this.closest('.special-date-row').remove();
            });
        });

        document.getElementById('reset-24-hours').addEventListener('click', function () {
            document.querySelectorAll('.weekly-closed').forEach(function (checkbox) {
                checkbox.checked = false;
                toggleWeeklyInputs(checkbox.dataset.day);
            });
            document.querySelectorAll('input[name$="[open_time]"]').forEach(function (input) {
                if (input.name.startsWith('weekly[')) {
                    input.value = '00:00';
                }
            });
            document.querySelectorAll('input[name$="[close_time]"]').forEach(function (input) {
                if (input.name.startsWith('weekly[')) {
                    input.value = '23:59';
                }
            });
        });
    });
</script>
@endpush
