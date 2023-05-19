<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    function create_new_job(Request $r)
    {
        return view('agency.add-new-job');
    }

    function insert(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'job_name' => 'required',
            'job_address' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        if ($validator->passes()) {
            extract($r->post());
            DB::table('job_master')->insert([
                'agency_id' => session('ENTITYID'),
                'name' => $job_name,
                'address' => $job_address,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
            return response()->json(['success' => '<p style="color:green;">Job Created</p>']);
        } else {
            $errors = $validator->errors()->getMessages();
            $html = genErrorList($errors);
            return response()->json(['error' => $html]);
        }
    }

    function list_jobs(Request $r, $job_type)
    {
        if (session('ROLE') == 'client') {
            if ($job_type == 'list-all') {
                $jobs = DB::table('job_master')
                    ->select([
                        'job_id',
                        'agency_master.name as agency',
                        'job_master.name as job_name',
                        'job_master.address',
                        'start_time',
                        'end_time'
                    ])
                    ->leftJoin('agency_master', 'agency_master.agency_id', '=', 'job_master.agency_id')
                    ->where('accepted_by', null)
                    ->get();
                return $jobs;
            } elseif ($job_type == 'list-accepted') {
                $jobs = DB::table('job_master')
                    ->select([
                        'job_id',
                        'agency_master.name as agency',
                        'job_master.name as job_name',
                        'job_master.address',
                        'start_time',
                        'end_time'
                    ])
                    ->leftJoin('agency_master', 'agency_master.agency_id', '=', 'job_master.agency_id')
                    ->where('accepted_by', session('ENTITYID'))
                    ->get();
                return $jobs;
            }
        } elseif (session('ROLE') == 'agency') {
            if ($job_type == 'list-all') {
                $jobs = DB::table('job_master')
                    ->select([
                        'job_id',
                        'job_master.name as job_name',
                        'job_master.address',
                        'start_time',
                        'end_time'
                    ])
                    ->where('accepted_by', null)
                    ->where('agency_id',session('ENTITYID'))
                    ->get();
                return $jobs;
            } elseif ($job_type == 'list-accepted') {
                $jobs = DB::table('job_master')
                    ->select([
                        'job_id',
                        'client_master.name as client',
                        'job_master.name as job_name',
                        'job_master.address',
                        'start_time',
                        'end_time'
                    ])
                    ->leftJoin('client_master', 'client_master.client_id', '=', 'job_master.accepted_by')
                    ->where('accepted_by', '!=',null)
                    ->where('agency_id',session('ENTITYID'))
                    ->get();
                return $jobs;
            }
        }
    }

    function apply_job(Request $r)
    {
        extract($r->post());
        $job = DB::table('job_master')->select(['latitude', 'longitude'])
            ->where('job_id', $job_id)
            ->where('accepted_by', null)
            ->first();
        $client_cord = DB::table('client_master')->select(['latitude', 'longitude'])->where('client_id', session('ENTITYID'))->first();
        if ($job) {
            //meter
            $distance = haversineGreatCircleDistance($job->latitude, $job->longitude, $client_cord->latitude, $client_cord->longitude);
            //km
            $distance = $distance / 1000;
            if ($distance > 15) {
                $distance = round($distance, 2);
                return response()->json(['error' => 'Can\'t accept, You are ' . $distance . 'Kms away from the job location']);
            }
            DB::table('job_master')
                ->where('job_id', $job_id)
                ->update(['accepted_by' => session('ENTITYID')]);
            return response()->json(['success' => 'You accepted the Job']);
        } else {
            return response()->json(['error' => 'Job is already accepted by someone']);
        }
        return $job;
    }
}
