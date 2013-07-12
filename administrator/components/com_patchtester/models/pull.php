 * @package        PatchTester
 * @copyright      Copyright (C) 2011 Ian MacLennan, Inc. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 * @package        PatchTester
class PatchtesterModelPull extends JModelLegacy
	/**
	 * @var  JHttp
	 */
	protected $transport;

	/**
	 * Constructor
	 *
	 * @param   array  $config  An array of configuration options (name, state, dbo, table_path, ignore_request).
	 *
	 * @since   12.2
	 * @throws  Exception
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		// Set up the JHttp object
		$options = new JRegistry;
		$options->set('userAgent', 'JPatchTester/1.0');
		$options->set('timeout', 120);

		$this->transport = JHttpFactory::getHttp($options, 'curl');
	}
		foreach ($lines AS $line)
		{
					if (strpos($line, 'diff --git') === 0)
					{
					if (strpos($line, 'index') === 0)
					{
					if (strpos($line, '---') === 0)
					{
					if (strpos($line, '+++') === 0)
					{
					if (strpos($line, 'new file mode') === 0)
					{
					if (strpos($line, 'deleted file mode') === 0)
					{
					if (strpos($line, '@@') === 0)
					{
		jimport('joomla.filesystem.file');
		if (is_null($pull->head->repo))
		{
		$patch = $this->transport->get($pull->diff_url)->body;
		foreach ($files as $file)
		{
			if ($file->action == 'deleted' && !file_exists(JPATH_ROOT . '/' . $file->old))
			{
			if ($file->action == 'added' || $file->action == 'modified')
			{
				if (file_exists(JPATH_COMPONENT . '/backups/' . md5($file->new) . '.txt'))
				{
				if ($file->action == 'modified' && !file_exists(JPATH_ROOT . '/' . $file->old))
				{
				$file->body = $this->transport->get($url)->body;
		foreach ($files as $file)
			if ($file->action == 'deleted' || (file_exists(JPATH_ROOT . '/' . $file->new) && $file->action == 'modified'))
			{
				if (!JFile::copy(JPath::clean(JPATH_ROOT . '/' . $file->old), JPATH_COMPONENT . '/backups/' . md5($file->old) . '.txt'))
				{
						, JPATH_ROOT . '/' . $file->old, JPATH_COMPONENT . '/backups/' . md5($file->old) . '.txt'));
					if (!JFile::write(JPath::clean(JPATH_ROOT . '/' . $file->new), $file->body))
					{
					if (!JFile::delete(JPATH::clean(JPATH_ROOT . '/' . $file->old)))
					{
		if (!$table->store())
		{
		jimport('joomla.filesystem.file');


		if ($table->applied_version != $version->getShortVersion())
		{
			$table->delete();

			return $this;
		if (!$files)
		{
			throw new Exception(sprintf(JText::_('%s - Error retrieving table data (%s)')
				, __METHOD__, htmlentities($table->data)));
		}

		foreach ($files as $file)
		{
			switch ($file->action)
			{
					if (!JFile::copy(
						JPATH_COMPONENT . '/backups/' . md5($file->old) . '.txt'
						, JPATH_ROOT . '/' . $file->old)
					)
					{
						throw new Exception(sprintf(
							JText::_('Can not copy file %s to %s')
							, JPATH_COMPONENT . '/backups/' . md5($file->old) . '.txt'
							, JPATH_ROOT . '/' . $file->old));

					if (!JFile::delete(JPATH_COMPONENT . '/backups/' . md5($file->old) . '.txt'))
					{
						throw new Exception(sprintf(
							JText::_('Can not delete the file: %s')
							, JPATH_COMPONENT . '/backups/' . md5($file->old) . '.txt'));
					if (!JFile::delete(JPath::clean(JPATH_ROOT . '/' . $file->new)))
					{
						throw new Exception(sprintf(
							JText::_('Can not delete the file: %s')
							, JPATH_ROOT . '/' . $file->new));
		$table->delete();