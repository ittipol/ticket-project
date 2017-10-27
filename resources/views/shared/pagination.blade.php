<?php
$linkLimit = 7;
?>

@if($paginator->lastPage() > 1)
<div class="mt4 pt4 mh3 ph2 bt b--light-silver clearfix tc">
  <ul class="pagination db fr-ns">
    <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
        <a href="{{ $paginator->url(1) }}"><i class="fa fa-chevron-left"></i></a>
     </li>
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        <?php
        $half_total_links = floor($linkLimit / 2);
        $from = $paginator->currentPage() - $half_total_links;
        $to = $paginator->currentPage() + $half_total_links;
        if ($paginator->currentPage() < $half_total_links) {
           $to += $half_total_links - $paginator->currentPage();
        }
        if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
            $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
        }
        ?>
        @if ($from < $i && $i < $to)
            <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endif
    @endfor
    @if($paginator->currentPage() < $paginator->lastPage())
    <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
        <a href="{{ $paginator->url($paginator->lastPage()) }}"><i class="fa fa-chevron-right"></i></a>
    </li>
    @endif
  </ul>
</div>
@endif