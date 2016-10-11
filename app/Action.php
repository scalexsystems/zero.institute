<?php namespace Scalex\Zero;

class Action
{
    const UPDATE_SCHOOL = 'school.update';
    const VIEW_PRIVATE_SCHOOL_INFO = 'school.read_all';

    const UPDATE_DEPARTMENT = 'department.update';
    const UPDATE_DISCIPLINE = 'discipline.update';

    const PEOPLE = 'people';
    const MANAGE_PEOPLE = 'people.manage';

    const VIEW_STUDENT = 'people.student_read';
    const VIEW_TEACHER = 'people.teacher_read';
    const VIEW_EMPLOYEE = 'people.employee_read';
}
