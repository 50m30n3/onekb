<?php

class Template
{
	private $template;

	function __construct( $template = null )
	{
		if( isset( $template ) )
		{
			$this->load( $template );
		}
	}

	public function load( $template )
	{
		if( !is_file( $template ) )
		{
			throw new FileNotFoundException("File not found: $template");
		}
		elseif( ! is_readable( $template ) )
		{
			throw new IOException("Could not access file: $template");
		}
		else
		{
			$this->template = $template;
		}
	}

	public function set( $var, $content )
	{
		$this->$var = $content;
	}

	public function delete( $var )
	{
		unset( $this->$var );
	}

	public function publish($output = true)
	{
		require $this->template;
	}
}

?>
