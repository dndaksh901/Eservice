<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('business_hours', 'weekly_hours')) {
            Schema::table('business_hours', function (Blueprint $table) {
                $table->json('weekly_hours')->nullable()->after('vendor_id');
            });
        }

        if (! Schema::hasColumn('business_hours', 'special_dates')) {
            Schema::table('business_hours', function (Blueprint $table) {
                $table->json('special_dates')->nullable()->after('weekly_hours');
            });
        }

        $vendorIds = DB::table('business_hours')->distinct()->pluck('vendor_id');
        foreach ($vendorIds as $vendorId) {
            $rows = DB::table('business_hours')->where('vendor_id', $vendorId)->orderBy('id')->get();
            $weekly = [];
            $special = [];

            foreach ($rows as $row) {
                if ($row->specific_date === null) {
                    $dayIndex = $row->day_of_week;
                    if (! isset($weekly[$dayIndex])) {
                        $weekly[$dayIndex] = [
                            'day_of_week' => $dayIndex,
                            'label' => null,
                            'is_closed' => false,
                            'slots' => [],
                        ];
                    }

                    if ($row->is_closed) {
                        $weekly[$dayIndex]['is_closed'] = true;
                        $weekly[$dayIndex]['slots'] = [];
                    } else {
                        if (! $weekly[$dayIndex]['is_closed']) {
                            $weekly[$dayIndex]['slots'][] = [
                                'open_time' => $row->open_time,
                                'close_time' => $row->close_time,
                                'capacity' => $row->slot_capacity ?? 1,
                            ];
                        }
                    }
                    continue;
                }

                $date = $row->specific_date;
                if (! isset($special[$date])) {
                    $special[$date] = [
                        'specific_date' => $date,
                        'is_closed' => false,
                        'slots' => [],
                    ];
                }

                if ($row->is_closed) {
                    $special[$date]['is_closed'] = true;
                    $special[$date]['slots'] = [];
                } elseif (! $special[$date]['is_closed']) {
                    $special[$date]['slots'][] = [
                        'open_time' => $row->open_time,
                        'close_time' => $row->close_time,
                        'capacity' => $row->slot_capacity ?? 1,
                    ];
                }
            }

            for ($day = 0; $day <= 6; $day++) {
                if (! isset($weekly[$day])) {
                    $weekly[$day] = [
                        'day_of_week' => $day,
                        'label' => null,
                        'is_closed' => false,
                        'slots' => [
                            ['open_time' => '00:00', 'close_time' => '23:59', 'capacity' => 1],
                        ],
                    ];
                }
            }

            ksort($weekly);
            $weekly = array_values($weekly);
            $special = array_values($special);

            $firstRow = $rows->first();
            if ($firstRow) {
                DB::table('business_hours')->where('id', $firstRow->id)->update([
                    'weekly_hours' => json_encode($weekly),
                    'special_dates' => json_encode($special),
                ]);
                DB::table('business_hours')->where('vendor_id', $vendorId)->where('id', '<>', $firstRow->id)->delete();
            }
        }

        Schema::table('business_hours', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropIndex(['vendor_id']);
            $table->dropColumn(['day_of_week', 'specific_date', 'slot_order', 'slot_capacity', 'open_time', 'close_time', 'is_closed']);
            $table->unique('vendor_id', 'business_hours_vendor_unique');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('business_hours', function (Blueprint $table) {
            $table->dropUnique('business_hours_vendor_unique');
            $table->integer('day_of_week')->nullable()->comment('0=Sunday,1=Monday,...6=Saturday')->after('vendor_id');
            $table->date('specific_date')->nullable()->comment('Override or special day schedule')->after('day_of_week');
            $table->integer('slot_order')->default(0)->after('specific_date');
            $table->integer('slot_capacity')->default(1)->after('slot_order');
            $table->time('open_time')->nullable()->after('slot_capacity');
            $table->time('close_time')->nullable()->after('open_time');
            $table->boolean('is_closed')->default(false)->after('close_time');
            $table->index('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });

        Schema::table('business_hours', function (Blueprint $table) {
            $table->dropColumn(['weekly_hours', 'special_dates']);
        });
    }
};
