<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude('bootstrap')
    ->exclude('public')
    ->exclude('resources/assets')
    ->exclude('resources/views')
    ->exclude('storage')
    ->exclude('vendor');

return (new Config())
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__ . '/.php_cs.cache')
    ->setRules([
        '@PSR12'                       => true,
        'align_multiline_comment'      => ['comment_type' => 'all_multiline'],
        'array_syntax'                 => ['syntax' => 'short'],
        'binary_operator_spaces'       => ['default' => 'align_single_space_minimal'],
        'blank_line_after_namespace'   => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement'  => ['statements' => ['return']],
        'braces'                       => [
            'allow_single_line_closure'                   => true,
            'position_after_anonymous_constructs'         => 'same',
            'position_after_control_structures'           => 'same',
            'position_after_functions_and_oop_constructs' => 'next',
        ],
        'cast_spaces'                 => true,
        'class_attributes_separation' => ['elements' => ['method' => 'one']],
        'class_definition'            => [
            'single_item_single_line'             => true,
            'multi_line_extends_each_single_line' => true,
        ],
        'combine_consecutive_issets'                  => true,
        'combine_consecutive_unsets'                  => true,
        'compact_nullable_typehint'                   => true,
        'concat_space'                                => ['spacing' => 'one'],
        'declare_equal_normalize'                     => ['space' => 'single'],
        'doctrine_annotation_array_assignment'        => true,
        'doctrine_annotation_braces'                  => true,
        'doctrine_annotation_indentation'             => true,
        'doctrine_annotation_spaces'                  => true,
        'elseif'                                      => true,
        'encoding'                                    => true,
        'escape_implicit_backslashes'                 => false,
        'explicit_indirect_variable'                  => true,
        'explicit_string_variable'                    => true,
        'full_opening_tag'                            => true,
        'function_declaration'                        => true,
        'function_typehint_space'                     => true,
        'include'                                     => true,
        'increment_style'                             => ['style' => 'post'],
        'indentation_type'                            => true,
        'line_ending'                                 => true,
        'linebreak_after_opening_tag'                 => true,
        'list_syntax'                                 => ['syntax' => 'short'],
        'lowercase_cast'                              => true,
        'constant_case'                               => ['case' => 'lower'],
        'lowercase_keywords'                          => true,
        'magic_constant_casing'                       => true,
        'method_argument_space'                       => ['on_multiline' => 'ensure_fully_multiline'],
        'method_chaining_indentation'                 => true,
        'multiline_comment_opening_closing'           => true,
        'multiline_whitespace_before_semicolons'      => ['strategy' => 'no_multi_line'],
        'native_function_casing'                      => true,
        'new_with_braces'                             => true,
        'no_blank_lines_after_class_opening'          => true,
        'no_blank_lines_after_phpdoc'                 => true,
        'no_break_comment'                            => true,
        'no_closing_tag'                              => true,
        'no_empty_comment'                            => true,
        'no_empty_phpdoc'                             => true,
        'no_empty_statement'                          => true,
        'no_extra_blank_lines'                        => ['tokens' => ['extra']],
        'no_leading_import_slash'                     => true,
        'no_leading_namespace_whitespace'             => true,
        'no_mixed_echo_print'                         => ['use' => 'echo'],
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_null_property_initialization'             => true,
        'no_php4_constructor'                         => true,
        'no_short_bool_cast'                          => true,
        'echo_tag_syntax'                             => ['format' => 'long', 'long_function' => 'echo'],
        'no_singleline_whitespace_before_semicolons'  => true,
        'no_spaces_after_function_name'               => true,
        'no_spaces_around_offset'                     => true,
        'no_spaces_inside_parenthesis'                => true,
        'no_superfluous_elseif'                       => true,
        'no_trailing_comma_in_list_call'              => true,
        'no_trailing_comma_in_singleline_array'       => true,
        'no_trailing_whitespace'                      => true,
        'no_trailing_whitespace_in_comment'           => true,
        'no_unneeded_control_parentheses'             => true,
        'no_unneeded_curly_braces'                    => true,
        'no_unneeded_final_method'                    => true,
        'no_unused_imports'                           => true,
        'no_useless_else'                             => true,
        'no_useless_return'                           => true,
        'no_whitespace_before_comma_in_array'         => true,
        'no_whitespace_in_blank_line'                 => true,
        'normalize_index_brace'                       => true,
        'not_operator_with_space'                     => false,
        'not_operator_with_successor_space'           => true,
        'object_operator_without_whitespace'          => true,
        'ordered_class_elements'                      => true,
        'ordered_imports'                             => true,
        'phpdoc_add_missing_param_annotation'         => ['only_untyped' => true],
        'phpdoc_align'                                => ['align' => 'vertical'],
        'phpdoc_annotation_without_dot'               => true,
        'phpdoc_indent'                               => true,
        'general_phpdoc_tag_rename'                   => ['replacements' => ['inheritDocs' => 'inheritDoc']],
        'phpdoc_no_access'                            => true,
        'phpdoc_no_alias_tag'                         => ['replacements' => ['type' => 'var', 'link' => 'see']],
        'phpdoc_no_empty_return'                      => true,
        'phpdoc_no_package'                           => true,
        'phpdoc_no_useless_inheritdoc'                => true,
        'phpdoc_order'                                => true,
        'phpdoc_return_self_reference'                => true,
        'phpdoc_scalar'                               => true,
        'phpdoc_separation'                           => true,
        'phpdoc_single_line_var_spacing'              => true,
        'phpdoc_summary'                              => true,
        'phpdoc_to_comment'                           => true,
        'phpdoc_trim'                                 => true,
        'phpdoc_types'                                => true,
        'phpdoc_types_order'                          => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
        'phpdoc_var_without_name'                     => true,
        'protected_to_private'                        => true,
        'return_type_declaration'                     => ['space_before' => 'none'],
        'semicolon_after_instruction'                 => true,
        'short_scalar_cast'                           => true,
        'simplified_null_return'                      => true,
        'single_blank_line_at_eof'                    => true,
        // 'single_blank_line_before_namespace' => true,
        'single_class_element_per_statement' => ['elements' => ['property']],
        'single_import_per_statement'        => true,
        'single_line_after_imports'          => true,
        'single_line_comment_style'          => ['comment_types' => ['asterisk', 'hash']],
        'single_quote'                       => true,
        'space_after_semicolon'              => true,
        'standardize_not_equals'             => true,
        'switch_case_semicolon_to_colon'     => true,
        'switch_case_space'                  => true,
        'ternary_operator_spaces'            => true,
        'ternary_to_null_coalescing'         => true,
        'trailing_comma_in_multiline'        => ['elements' => ['arrays']],
        'trim_array_spaces'                  => true,
        'unary_operator_spaces'              => true,
        'visibility_required'                => ['elements' => ['const', 'method', 'property']],
        'whitespace_after_comma_in_array'    => true,
        'yoda_style'                         => false,
    ])
    ->setFinder($finder);
