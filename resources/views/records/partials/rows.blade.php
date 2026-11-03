<dl class="rec-dl {{ !empty($single) ? 'rec-dl--single' : '' }}">
    @foreach ($rows as $r)
        @php($long = $r['kind'] === 'long' || $r['kind'] === 'chips')
        <div class="rec-dl__row {{ $long ? 'is-long' : '' }}">
            <dt>{{ $r['label'] }}</dt>
            <dd>
                @if ($r['text'] === null)
                    <span class="rec-nil">Not provided</span>
                @elseif ($r['kind'] === 'nin')
                    <span class="rec-nin" data-full="{{ $r['text'] }}" data-masked="{{ $r['masked'] }}">{{ $r['masked'] }}</span>
                    <button type="button" class="rec-link" data-rec-reveal aria-pressed="false">Show</button>
                @elseif ($r['kind'] === 'phone')
                    <a class="rec-tel" href="tel:{{ preg_replace('/[^0-9+]/', '', $r['text']) }}">{{ $r['text'] }}</a>
                @elseif ($r['label'] === 'Email' && filter_var($r['text'], FILTER_VALIDATE_EMAIL))
                    <a class="rec-tel" href="mailto:{{ $r['text'] }}">{{ $r['text'] }}</a>
                @elseif ($r['kind'] === 'chips')
                    <span class="rec-chips">
                        @foreach (explode(', ', $r['text']) as $chip)<span>{{ $chip }}</span>@endforeach
                    </span>
                @elseif ($r['kind'] === 'long')
                    <span class="rec-prose">{{ $r['text'] }}</span>
                @else
                    {{ $r['text'] }}
                @endif
            </dd>
        </div>
    @endforeach
</dl>
