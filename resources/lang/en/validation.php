<?php

return [

    'accepted'             => 'The <u>:attribute</u> must be accepted.',
    'active_url'           => 'The <u>:attribute</u> is not a valid URL.',
    'after'                => 'The <u>:attribute</u> must be a date after :date.',
    'after_or_equal'       => 'The <u>:attribute</u> must be a date after or equal to :date.',
    'alpha'                => 'The <u>:attribute</u> may only contain letters.',
    'alpha_dash'           => 'The <u>:attribute</u> may only contain letters, numbers, dashes and underscores.',
    'alpha_num'            => 'The <u>:attribute</u> may only contain letters and numbers.',
    'array'                => 'The <u>:attribute</u> must be an array.',
    'before'               => 'The <u>:attribute</u> must be a date before :date.',
    'before_or_equal'      => 'The <u>:attribute</u> must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The <u>:attribute</u> must be between :min and :max.',
        'file'    => 'The <u>:attribute</u> must be between :min and :max kilobytes.',
        'string'  => 'The <u>:attribute</u> must be between :min and :max characters.',
        'array'   => 'The <u>:attribute</u> must have between :min and :max items.',
    ],
    'boolean'              => 'The <u>:attribute</u> field must be true or false.',
    'confirmed'            => 'The <u>:attribute</u> confirmation does not match.',
    'date'                 => 'The <u>:attribute</u> is not a valid date.',
    'date_equals'          => 'The <u>:attribute</u> must be a date equal to :date.',
    'date_format'          => 'The <u>:attribute</u> does not match the format :format.',
    'different'            => 'The <u>:attribute</u> and :other must be different.',
    'digits'               => 'The <u>:attribute</u> must be :digits digits.',
    'digits_between'       => 'The <u>:attribute</u> must be between :min and :max digits.',
    'dimensions'           => 'The <u>:attribute</u> has invalid image dimensions.',
    'distinct'             => 'The <u>:attribute</u> field has a duplicate value.',
    'email'                => 'The <u>:attribute</u> must be a valid email address.',
    'ends_with'            => 'The <u>:attribute</u> must end with one of the following: :values',
    'exists'               => 'The selected <u>:attribute</u> is invalid.',
    'file'                 => 'The <u>:attribute</u> must be a file.',
    'filled'               => 'The <u>:attribute</u> field must have a value.',
    'gt'                   => [
        'numeric' => 'The <u>:attribute</u> must be greater than :value.',
        'file'    => 'The <u>:attribute</u> must be greater than :value kilobytes.',
        'string'  => 'The <u>:attribute</u> must be greater than :value characters.',
        'array'   => 'The <u>:attribute</u> must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'The <u>:attribute</u> must be greater than or equal :value.',
        'file'    => 'The <u>:attribute</u> must be greater than or equal :value kilobytes.',
        'string'  => 'The <u>:attribute</u> must be greater than or equal :value characters.',
        'array'   => 'The <u>:attribute</u> must have :value items or more.',
    ],
    'image'                => 'The <u>:attribute</u> must be an image.',
    'in'                   => 'The selected <u>:attribute</u> is invalid.',
    'in_array'             => 'The <u>:attribute</u> field does not exist in :other.',
    'integer'              => 'The <u>:attribute</u> must be an integer.',
    'ip'                   => 'The <u>:attribute</u> must be a valid IP address.',
    'ipv4'                 => 'The <u>:attribute</u> must be a valid IPv4 address.',
    'ipv6'                 => 'The <u>:attribute</u> must be a valid IPv6 address.',
    'json'                 => 'The <u>:attribute</u> must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'The <u>:attribute</u> must be less than :value.',
        'file'    => 'The <u>:attribute</u> must be less than :value kilobytes.',
        'string'  => 'The <u>:attribute</u> must be less than :value characters.',
        'array'   => 'The <u>:attribute</u> must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The <u>:attribute</u> must be less than or equal :value.',
        'file'    => 'The <u>:attribute</u> must be less than or equal :value kilobytes.',
        'string'  => 'The <u>:attribute</u> must be less than or equal :value characters.',
        'array'   => 'The <u>:attribute</u> must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'The <u>:attribute</u> may not be greater than :max.',
        'file'    => 'The <u>:attribute</u> may not be greater than :max kilobytes.',
        'string'  => 'The <u>:attribute</u> may not be greater than :max characters.',
        'array'   => 'The <u>:attribute</u> may not have more than :max items.',
    ],
    'mimes'                => 'The <u>:attribute</u> must be a file of type: :values.',
    'mimetypes'            => 'The <u>:attribute</u> must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The <u>:attribute</u> must be at least :min.',
        'file'    => 'The <u>:attribute</u> must be at least :min kilobytes.',
        'string'  => 'The <u>:attribute</u> must be at least :min characters.',
        'array'   => 'The <u>:attribute</u> must have at least :min items.',
    ],
    'not_in'               => 'The selected <u>:attribute</u> is invalid.',
    'not_regex'            => 'The <u>:attribute</u> format is invalid.',
    'numeric'              => 'The <u>:attribute</u> must be a number.',
    'password'             => 'The password is incorrect.',
    'present'              => 'The <u>:attribute</u> field must be present.',
    'regex'                => 'The <u>:attribute</u> format is invalid.',
    'required'             => 'The <u>:attribute</u> field is required.',
    'required_if'          => 'The <u>:attribute</u> field is required when :other is :value.',
    'required_unless'      => 'The <u>:attribute</u> field is required unless :other is in :values.',
    'required_with'        => 'The <u>:attribute</u> field is required when :values is present.',
    'required_with_all'    => 'The <u>:attribute</u> field is required when :values are present.',
    'required_without'     => 'The <u>:attribute</u> field is required when :values is not present.',
    'required_without_all' => 'The <u>:attribute</u> field is required when none of :values are present.',
    'same'                 => 'The <u>:attribute</u> and :other must match.',
    'size'                 => [
        'numeric' => 'The <u>:attribute</u> must be :size.',
        'file'    => 'The <u>:attribute</u> must be :size kilobytes.',
        'string'  => 'The <u>:attribute</u> must be :size characters.',
        'array'   => 'The <u>:attribute</u> must contain :size items.',
    ],
    'starts_with'          => 'The <u>:attribute</u> must start with one of the following: :values',
    'string'               => 'The <u>:attribute</u> must be a string.',
    'timezone'             => 'The <u>:attribute</u> must be a valid zone.',
    'unique'               => 'The <u>:attribute</u> has already been taken.',
    'uploaded'             => 'The <u>:attribute</u> failed to upload.',
    'url'                  => 'The <u>:attribute</u> format is invalid.',
    'uuid'                 => 'The <u>:attribute</u> must be a valid UUID.',

    /**
     * Custom Validation Language Lines
     */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /**
     * Custom Validation Attributes
     */
    'attributes' => [],

];
