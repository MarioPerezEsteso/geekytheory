<?php

namespace Tests\Helpers;

class TestConstants
{
    /**
     * Model resource types.
     */
    const RESOURCE_TYPE_COURSE = 'Course';

    /********************
     * Model constants. *
     ********************/
    /**
     * Course.php
     */
    const MODEL_COURSE_DIFFICULTY_BEGINNER = 'beginner';
    const MODEL_COURSE_DIFFICULTY_INTERMEDIATE = 'intermediate';
    const MODEL_COURSE_DIFFICULTY_ADVANCED = 'advanced';

    /**
     * Lesson.php
     */
    const MODEL_LESSON_TEMPLATE_HEADER_VIDEO = 'video';
    const MODEL_LESSON_TEMPLATE_HEADER_REGISTER = 'headerRegister';
    const MODEL_LESSON_TEMPLATE_HEADER_GOPREMIUM = 'headerGopremium';

    /**
     * Subscription.php
     */
    const MODEL_SUBSCRIPTION_PLAN_NAME = 'main';
    const MODEL_SUBSCRIPTION_PLAN_MONTHLY = 'monthly';
    const MODEL_SUBSCRIPTION_PLAN_MONTHLY_PRICE_EUR = 15;
}