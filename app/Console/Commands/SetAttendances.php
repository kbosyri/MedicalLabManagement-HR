<?php

namespace App\Console\Commands;

use App\Models\AbsenceDate;
use App\Models\AttendanceDate;
use App\Models\Attendence;
use App\Models\LeaveDate;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SetAttendances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-attendances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds Attendances And Absences To The Database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting To Add Attendances And Absences!");
        $staff = Staff::where("is_active",true)->get();
        $staff_ids = [];
        $now = Carbon::now();
        $start = $now->startOfDay()->toDateTimeString();

        $end = $now->endOfDay()->toDateTimeString();
        $this->info("Start: ".$start);
        $this->info("End: ".$end);
        $attendances = Attendence::whereBetween('time',[$start,$end])
                                    ->where('is_ending',false)->get();
        $count = count($attendances) + count($staff);
        $this->info("Staff: ".count($staff));
        $this->info("Attendances: ".count($attendances));
        $this->info("Count: ".$count);
        $this->info("Please Wait!....");
        $this->output->progressStart($count);
        foreach($attendances as $attendance)
        {
            $this->output->progressAdvance(1);
            array_push($staff_ids,$attendance->staff_id);
            if(Attendence::whereBetween('time',[$start,$end])
            ->where('is_ending',true)
            ->where('staff_id',$attendance->staff_id)
            ->exists())
            {
                $date = new AttendanceDate();

                $date->staff_id = $attendance->staff_id;
                $date->date = $now;

                $date->save();
            }
            else
            {
                if(AbsenceDate::where('date',$now)
                ->where('staff_id',$attendance->staff_id)
                ->exists())
                {
                    continue;
                }
                $date = new AbsenceDate();

                $date->staff_id = $attendance->staff_id;
                $date->date = $now;

                $date->save();
            }
        }

        foreach($staff as $member)
        {
            $this->output->progressAdvance(1);
            if(!in_array($member->id,$staff_ids))
            {
                if(!$member->is_admin)
                {
                    if(in_array($now->dayName,$member->schedule()->days_of_week))
                    {
                        if(LeaveDate::where('staff_id',$member->id)->where('date',$now->toDateString())->exists())
                        {
                            continue;
                        }
                        if(AbsenceDate::where('date',$now)
                        ->where('staff_id',$member->id)
                        ->exists())
                        {
                            continue;
                        }
                        $date = new AbsenceDate();
                    
                        $date->staff_id = $member->id;
                        $date->date = $now;
                    
                        $date->save();
                    }
                }
                if(AbsenceDate::where('date',$now)
                ->where('staff_id',$member->id)
                ->exists())
                {
                    continue;
                }
                $date = new AbsenceDate();

                $date->staff_id = $member->id;
                $date->date = $now;

                $date->save();
            }
        }

        $this->output->progressFinish();
        $this->info('Finished Adding Attendances And Absences!');
    }
}
