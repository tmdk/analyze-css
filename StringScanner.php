<?php

/**
 * Class StringScanner
 */
class StringScanner {

	/**
	 * @var bool
	 */
	private $debug = false;
	/**
	 * @var int
	 */
	private $position;
	/**
	 * @var string
	 */
	private $string;

	/**
	 * StringScanner constructor.
	 *
	 * @param $string
	 * @param $debug
	 */
	public function __construct( $string, $debug = false ) {
		$this->string   = $string;
		$this->debug    = $debug;
		$this->position = 0;
	}

	/**
	 * @param string $regex
	 */
	public function skip( $regex ) {
		if ( preg_match( "/$regex/smA", $this->string, $matches, 0, $this->position ) ) {
			$this->position += strlen( $matches[0] );
			if ( $this->debug ) {
				echo "skipping '$regex', new position: $this->position\n";
			}
		}
		if ( $this->debug ) {
			echo "skipping '$regex': no match\n";
		}
	}

	/**
	 * @param string $regex
	 *
	 * @return bool
	 */
	public function skipUntil( $regex ) {
		if ( preg_match( "/$regex/sm", $this->string, $matches, PREG_OFFSET_CAPTURE, $this->position ) ) {
			$this->position = $matches[0][1];
			if ( $this->debug ) {
				echo "skipping until '$regex', new position: $this->position\n";
			}

			return true;
		}

		if ( $this->debug ) {
			echo "skipping until '$regex': no match\n";
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function hasNext() {
		return $this->position < strlen( $this->string );
	}

    /**
     * @param string $regex
     * @param array & $regex
     *
     * @return bool
     */
    public function accept( $regex, &$matchesRef = null ) {
        if ( preg_match( "/$regex/smA", $this->string, $matches, 0, $this->position ) ) {
            $this->position += strlen( $matches[0] );

            if ( $this->debug ) {
                echo "accepting '$regex', new position: $this->position\n";
            }

            if ( $matchesRef !== null ) {
                $matchesRef = $matches;
            }

            return true;
        }

        if ( $this->debug ) {
            echo "accept '$regex': no match\n";
        }

        return false;
    }

	/**
	 * @param string $regex
	 * @param array & $regex
	 *
	 * @return bool
	 */
	public function acceptUntil( $regex, &$matchesRef = null ) {
		if ( preg_match( "/$regex/sm", $this->string, $matches, PREG_OFFSET_CAPTURE, $this->position ) ) {
			$until = $matches[0][1];

			if ( $matchesRef !== null ) {
				$matchesRef = [ substr( $this->string, $this->position, $until - $this->position ) ];
			}

			$this->position = $until;

			if ( $this->debug ) {
				echo "accepting until '$regex', new position: $this->position\n";
			}

			return true;
		}

		if ( $this->debug ) {
			echo "accepting until '$regex': no match\n";
		}

		return false;
	}

	/**
	 * @return int
	 */
	public function position() {
		return $this->position;
	}

	/**
	 * @param string $val
	 *
	 * @return string
	 */
	public function escape( $val ) {
		return preg_quote( $val, '/' );
	}

}
