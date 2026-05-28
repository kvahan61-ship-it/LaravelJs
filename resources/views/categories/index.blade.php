<div class="categories-nav-container" style="margin: 20px 0 30px 0; display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">

    <a href="{{ route('home', request()->only(['search'])) }}"
       class="category-filter-btn {{ !request('category_id') ? 'active-cat' : '' }}"
       style="text-decoration: none; padding: 10px 22px; border-radius: 25px; border: 1px solid #e0e0e0; font-weight: 600; font-size: 15px; transition: 0.3s;
              background: {{ !request('category_id') ? '#007bff' : '#fff' }};
              color: {{ !request('category_id') ? '#fff' : '#444' }};
              box-shadow: {{ !request('category_id') ? '0 4px 10px rgba(0,123,255,0.3)' : 'none' }};">
        Բոլորը
    </a>

    @foreach($categories as $cat)
        <a href="{{ route('home', array_merge(request()->only(['search']), ['category_id' => $cat->id])) }}"
           class="category-filter-btn {{ request('category_id') == $cat->id ? 'active-cat' : '' }}"
           style="text-decoration: none; padding: 10px 22px; border-radius: 25px; border: 1px solid #e0e0e0; font-weight: 600; font-size: 15px; transition: 0.3s;
                  background: {{ request('category_id') == $cat->id ? '#007bff' : '#fff' }};
                  color: {{ request('category_id') == $cat->id ? '#fff' : '#444' }};
                  box-shadow: {{ request('category_id') == $cat->id ? '0 4px 10px rgba(0,123,255,0.3)' : 'none' }};">
            {{ $cat->name }}
        </a>
    @endforeach
</div>
