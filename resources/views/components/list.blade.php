<div class="ui middle aligned divided selection relaxed large list">
    @foreach ($items as $item)
        @component('components.list-item', [
            'item_url' => $item['url'] ?? null,
            'item_label' => $item['label'],
            'item_description' => $item['description'] ?? null,
            'item_icon' => $item['icon'] ?? null,
        ])
        @endcomponent
    @endforeach
</div>