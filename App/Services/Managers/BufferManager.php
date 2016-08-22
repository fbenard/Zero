<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class BufferManager
{
	/**
	 *
	 */
	
	public function clearBuffer()
	{
		// Get buffers handlers
		
		$handlers = ob_list_handlers();


		// Parse each handler
		
		while (empty($handlers) === false)
		{
			// Clean the handler

			ob_end_clean();


			// Get the next handler

			$handlers = ob_list_handlers();
		}
	}


	/**
	 *
	 */

	public function startBuffer()
	{
		// Start output buffer

		ob_start();
	}


	/**
	 *
	 */

	public function stopBuffer()
	{
		// Get output buffer content

		$buffer = ob_get_contents();


		// Clean output buffer
		
		ob_end_clean();


		return $buffer;
	}
}

?>
