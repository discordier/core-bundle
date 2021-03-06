<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Contao;


/**
 * Front end content element "accordion" (wrapper start).
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class ContentAccordionStart extends \ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_accordionStart';


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		if (TL_MODE == 'BE')
		{
			$this->strTemplate = 'be_wildcard';

			/** @var BackendTemplate|object $objTemplate */
			$objTemplate = new \BackendTemplate($this->strTemplate);

			$this->Template = $objTemplate;
			$this->Template->title = $this->mooHeadline;
		}

		$classes = \StringUtil::deserialize($this->mooClasses);

		$this->Template->toggler = $classes[0] ?: 'toggler';
		$this->Template->accordion = $classes[1] ?: 'accordion';
		$this->Template->headlineStyle = $this->mooStyle;
		$this->Template->headline = $this->mooHeadline;
	}
}
