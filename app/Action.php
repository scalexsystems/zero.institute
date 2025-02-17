<?php

namespace Scalex\Zero;

class Action
{
    const UPDATE_SCHOOL = 'school.update';
    const VIEW_PRIVATE_SCHOOL_INFO = 'school.read_all';

    const UPDATE_DEPARTMENT = 'department.update';
    const UPDATE_DISCIPLINE = 'discipline.update';

    const PEOPLE = 'people';
    const MANAGE_PEOPLE = 'people.manage';

    const VIEW_STUDENT = 'people.student.read';
    const VIEW_TEACHER = 'people.teacher.read';
    const VIEW_EMPLOYEE = 'people.employee.read';

    const UPDATE_STUDENT = 'people.student.update';
    const UPDATE_TEACHER = 'people.teacher.update';
    const UPDATE_EMPLOYEE = 'people.employee.update';

    const INVITE_STUDENT = 'people.student.invite';

    const INVITE_TEACHER = 'people.teacher.invite';

    const INVITE_EMPLOYEE = 'people.employee.invite';
    // -- @next --
    /*
     * @model \Scalex\Zero\Models\Course
     */
    const CREATE_COURSE = 'course.create';
    const UPDATE_COURSE = 'course.update';
    const DELETE_COURSE = 'course.delete';
}
