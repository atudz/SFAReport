<?php

namespace App\Core\Builder;

use Illuminate\Pagination\BootstrapThreePresenter;

class PaginatorBuilder extends BootstrapThreePresenter
{
	/**
	 * The limiter count values
	 * @var unknown
	 */	
	protected $limiterCounts = [10,25,50,100];
	
	/**
	 * The limit url key
	 * @var unknown
	 */
	protected $limitName = 'limit';
	
	/**
	 * Max page limit
	 * @var unknown
	 */
	protected $maxPage = 3;
	
	
	/**
	 * Return the options need to be added to the url
	 * @return array
	 */
	public function getAppendOptions()
	{
		$options = [];
		if($this->paginator->getSortColumn())
		{
			$options['sort'] = $this->paginator->getSortColumn();
		}
		if($this->paginator->getSortOrder())
		{
			$options['order'] = $this->paginator->getSortOrder();
		}
		
		return $options;
	}
	/**
	 * Convert the URL window into Bootstrap HTML.
	 *
	 * @return string
	 */
	public function render($limiter=true)
	{
		if ($this->paginator->total()) {
			$this->paginator->appends($this->getAppendOptions());
			$paginator = sprintf(
					'<ul class="pagination pagination-table pull-left">%s %s %s %s %s</ul>',
					$this->getFirstButton(),
					$this->getPreviousButton('&lsaquo;'),
					$this->getCustomLinks(),
					$this->getNextButton('&rsaquo;'),
					$this->getLastButton()
			);
	
			$limit = '';
			if($limiter)
			{
				$limit = 
						'<ul class="pagination pagination-table pull-right">'.
						$this->getDisplayCount().
						$this->getLimterLinks().
						$this->getPerPage().
						'</ul>';
			}
			
			return $paginator.$limit;
		}
	
		return '';
	}
	
	/**
	 * Display limiter links
	 * @return string
	 */
	public function getLimterLinks()
	{
		$html = '';
		foreach($this->limiterCounts as $count)
		{
			$this->paginator->appends(array_merge([$this->limitName=>$count],$this->getAppendOptions()));
			if(($this->paginator->currentPage() * $count) > $this->paginator->total())
			{
				$page = 1;
			}
			else
			{
				$page = $this->paginator->currentPage();
			}
			
			$link = $this->paginator->url($page);
			if($count == $this->paginator->perPage())
			{
				$html .= $this->getActivePageWrapper($count);
			} 	
			else 
			{
				$html .= $this->getAvailablePageWrapper($link,$count);
			}
		}
		return $html;
	}
	
	/**
	 * Display pagination per page text
	 * @param string $text
	 * @return string
	 */
	public function getPerPage($text='per page')
	{
		
		return '<li><span class="paginate-per-page">'.$text.'</span></li>';
	}
	
	/**
	 * Display pagination count
	 * @param string $text
	 * @return string
	 */
	public function getDisplayCount($text='Displaying')
	{
		$perPage = $this->paginator->perPage();
		$total = $this->paginator->total();
		$displayCount = $perPage * $this->paginator->currentPage();
		$displayOf = ($displayCount >= $total) ? $total : $displayCount;
		$displayFrom = ($displayCount - $perPage) + 1; 
		$html = sprintf(
					 '<li><span class="paginate-display-count">%s %s -%s of %s</span></li>',
					 $text,	
					 $displayFrom,
			 		 $displayOf,
			 		 $total
				);
		return $html;
	}
	
	
	/**
	 * Get the previous page pagination element.
	 *
	 * @param  string  $text
	 * @return string
	 */
	public function getFirstButton($text = '&laquo;')
	{
		// If the current page is less than or equal to one, it means we can't go any
		// further back in the pages, so we will render a disabled previous button
		// when that is the case. Otherwise, we will give it an active "status".
		if ($this->paginator->currentPage() == 1) {
			return $this->getDisabledTextWrapper($text);
		}
	
		$url = $this->paginator->url(1);
	
		return $this->getPageLinkWrapper($url, $text, 'prev');
	}
	
	/**
	 * Get the next page pagination element.
	 *
	 * @param  string  $text
	 * @return string
	 */
	public function getLastButton($text = '&raquo;')
	{
		// If the current page is greater than or equal to the last page, it means we
		// can't go any further into the pages, as we're already on this last page
		// that is available, so we will make it the "next" link style disabled.
		if (!$this->paginator->hasMorePages()) {
			return $this->getDisabledTextWrapper($text);
		}
	
		$url = $this->paginator->url($this->paginator->lastPage());
	
		return $this->getPageLinkWrapper($url, $text, 'next');
	}
	
	/**
	 * Get custom pagination links
	 * @return string
	 */
	public function getCustomLinks()
	{
		$page = $this->paginator->currentPage();
		$lastPage = $this->paginator->lastPage();
		$lower = $page;
		$upper = $page+$this->maxPage;
		$upper = $upper >= $lastPage ? $lastPage : $upper;
		$html = '';
		for($i=$lower;$i<=$upper;$i++)
		{
			$link = $this->paginator->url($i);
			$html .= ($page == $i) ? $this->getActivePageWrapper($i) : $this->getAvailablePageWrapper($link,$i);
		}
		
		$lowerDot = ($lower <= 1) ? '' : $this->getDots();
		$upperDot = ($upper>=$this->paginator->lastPage()) ? '' : $this->getDots();
		$html = $lowerDot.$html.$upperDot;
		return $html;
	}
	
}
