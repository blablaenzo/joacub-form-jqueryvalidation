<?php
/**
 * Description
 *
 * @category  Acsi
 * @package   Acsi\
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace ZfJoacubFormJqueryValidate\Renderer;

class RendererCollectionTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var RendererCollection
	 */
	private $rendererCollection = null;

	/**
	 * Setup
	 */
	public function setUp()
	{
		$this->rendererCollection = new RendererCollection($this->getMock('ZfJoacubFormJqueryValidate\FormManager'));
		for ($i = 0; $i < 3; $i++)
		{
			$renderer = $this->getMock('ZfJoacubFormJqueryValidate\Renderer\RendererInterface');
			$this->rendererCollection->addRenderer($renderer);
		}
	}

	public function testGetRenderers()
	{
		$this->assertCount(3, $this->rendererCollection->getRenderers());
	}

	public function testPreRenderFormIsCalledOnInnerRenderers()
	{
		$formAlias = 'testAlias';
		$viewMock = $this->getMock('Zend\View\Renderer\PhpRenderer');

		/** @var $renderer \PHPUnit_Framework_MockObject_MockObject */
		foreach ($this->rendererCollection->getRenderers() as $renderer)
		{
			$renderer->expects($this->once())
			         ->method('preRenderForm')
			         ->with($formAlias, $this->equalTo($viewMock));
		}

		$this->rendererCollection->preRenderForm($formAlias, $viewMock);
	}

	public function testPreRenderInputFieldIsCalledOnInnerRenderers()
	{
		$elemMock = $this->getMock('Zend\Form\ElementInterface');

		/** @var $renderer \PHPUnit_Framework_MockObject_MockObject */
		foreach ($this->rendererCollection->getRenderers() as $renderer)
		{
			$renderer->expects($this->once())
			         ->method('preRenderInputField')
			         ->with($this->equalTo($elemMock));
		}

		$this->rendererCollection->preRenderInputField($elemMock);
	}
}