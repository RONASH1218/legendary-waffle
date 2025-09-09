<?php

	$madara_required_plugins = array(
		array(
			'name'     => 'Option Tree',
			'slug'     => 'option-tree',
			'required' => true,
			'source'   => get_template_directory() . '/app/plugins/packages/option-tree-2.3.7.2.zip',
			'version' => '2.7.3.2'
		),

		array(
			'name'     => 'Madara - Shortcodes',
			'slug'     => 'madara-shortcodes',
			'source'   => get_template_directory() . '/app/plugins/packages/madara-shortcodes.zip',
			'required' => true,
			'version'  => '1.5.5.8'
		),

		array(
			'name'     => 'Madara - Core',
			'slug'     => 'madara-core',
			'source'   => get_template_directory() . '/app/plugins/packages/madara-core.zip',
			'required' => true,
			'version'  => '1.7.3.12'
		),

		array(
			'name'     => 'Widget Logic',
			'slug'     => 'widget-logic',
			'required' => false
		),

	);
