<?php

namespace Scalex\Zero\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Scalex\Zero\Events\FeeSession\Updated;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Repositories\FeePaymentRepository;

class GenerateFeePaymentRequests implements ShouldQueue
{
    /**
     * @var \Scalex\Zero\Repositories\FeePaymentRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(FeePaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  Updated $event
     *
     * @return void
     */
    public function handle(Updated $event)
    {
        if ($event->feeSession->accepting and $event->feeSession->payments()->count() === 0) {
            Student::where('school_id', $event->feeSession->school_id)
                   ->chunk(100, function (Collection $students) use ($event) {
                       $students->each(function (Student $student) use ($event) {
                           $this->repository->createWith($event->feeSession, $student, [
                               'amount' => 0,
                               'amount_manual' => true,
                               'deadline' => $event->feeSession->ended_at,
                           ]);
                       });
                   });
        }
    }
}
