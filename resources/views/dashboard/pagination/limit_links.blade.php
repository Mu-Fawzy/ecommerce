@php
    // config
    $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
@endphp

@if ($paginator->lastPage() > 1)
    <ul class="pagination mt-4 mb-0 float-left">
        <li class="page-item page-prev disabled {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}" tabindex="-1">
            <a class="page-link" href="{{ $paginator->url(1) }}">First</a>
        </li>

        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
            $half_total_links = floor($link_limit / 2);
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
                <li class="page-item  {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endif
        @endfor

        <li class="page-item page-next {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">Last</a>
        </li>
    </ul>
@endif
