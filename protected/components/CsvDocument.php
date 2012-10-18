<?php
	/** 
	 * CsvDocument
	 * A very simple utility class for dynamically building
	 * csv documents on the fly.
	 * The class handles the basic character escaping and 
	 * other formatting required to generate a consistent 
	 * CSV document.
	 *
	 * @author Jason Larke
	 * @date 24/08/2012
	 */
	class CsvDocument
	{
		// The current document is stored here
		private $document;
		// Column headers, keep a reference of count/values.
		private $columns;
		// Normalized line endings
		private $lineEnding;
		
		/** 
		 * Construct a new CsvDocument instance
		 * @param $columns an array of the column headers for the CSV document. Example: array("column1", "column2", "column3")
		 * @param $includeHeaders bool, optional. Whether the generated CsvDocument should include the column header values at the top.
		 * @param $lineEndings string, the desired line-endings for the document (\r\n, \n..etc)
		 */
		public function __construct($columns, $includeHeaders=true,$lineEndings = "\n")
		{
			if (!is_array($columns))
				throw new Exception('Invalid value specified for parameter \'$columns\'');
			
			$this->document = "";
			$this->columns = $columns;
			$this->lineEnding = $lineEndings;
			
			if ($includeHeaders)
				$this->addRow($columns);
		}
		
		/**
		 * Add a new row to the current document.
		 * If $rowData does not match the length of $columns,
		 * it will be expanded/contracted to fit.
		 * @param $rowData an array containing the scalar values to insert into the row. It can also be a single scalar value.
		 */
		public function addRow($rowData=array())
		{
			
			// validate the input.
			if (!is_array($rowData) && !is_scalar($rowData) && $rowData !== NULL)
				throw new Exception('Invalid value specified for parameter \'$rowData\'');
			else if (is_scalar($rowData) || $rowData === NULL)
				$rowData = array($rowData);
				
			// Normalize the array size to match the number of columns in the document.
			if (count($rowData) < count($this->columns))
				$rowData = array_pad($rowData, count($this->columns), ""); //pad the array to the correct size;	
			else
				$rowData = array_slice($rowData, 0, count($this->columns), "");
				
			
			// Build the new, formatted array of data.
			$cells = array();
			
			foreach($rowData as $cell)
			{
				// Also perform validation simultaneously
				if ($cell !== null && !is_scalar($cell))
					throw new Exception("Non-scalar value found in a cell");
				else
					$cells[] = $this->encodeField($cell);
			}

			if (!empty($this->document))
				$this->document .= $this->lineEnding;
				
			$this->document .= implode(",", $cells);
		}
		
		/** 
		 * Get the current document content
		 * @return the current document
		 */
		public function getDocument()
		{
			return $this->document;
		}
		
		/**
		 * Encode a given cell to ensure that it is CSV compatible.
		 * This involves appending and prepending quotation marks around the cell value
		 * if necessary, and escaping all existing quotation marks with another quotation mark.
		 * @param $cell the cell value to encode if necessary
		 * @return the csv-safe value of the cell.
		 */
		private function encodeField($cell)
		{
			if ($cell === null)
				return "";	
			else if (strpos($cell, ",") !== false || strpos($cell, '"') !== false || strpos($cell, "\n") !== false)
				return '"' . str_replace('"', '""', $cell) . '"';
			else
				return $cell;			
		}
	}
?>