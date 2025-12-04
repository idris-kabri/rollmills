<div>
    <style>
        :root {
            --primary-bg: #F9FAFB;
            --card-bg: #FFFFFF;
            --icon-bg: #EEF2FF;
            --text-color: #1F2937;
            --border-color: #E5E7EB;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--primary-bg);
            padding: 20px;
            margin: 0;
        }

        .category-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .search-wrapper {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
        }
        
        .search-input {
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            width: 100%;
            max-width: 300px;
            outline: none;
        }

        .category-header {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 15px;
        }

        .category-row {
            display: flex;
            justify-content: flex-start;
            gap: 15px;
            width: 100%;
            overflow-x: auto;
            padding-bottom: 15px;
            scrollbar-width: none;
        }

        .category-row::-webkit-scrollbar {
            display: none;
        }

        .category-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
            border-radius: 12px;
            padding: 20px 10px;
            
            width: 140px; 
            min-width: 140px; 
            
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
            border-color: #4F46E5;
        }

        .icon-wrapper {
            width: 60px;
            height: 60px;
            background-color: var(--icon-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .category-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .category-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-color);
            text-align: center;
        }
        
        .no-results {
            text-align: center;
            width: 100%;
            color: #6b7280;
            padding: 20px;
        }
    </style>

    <div class="category-container">
        
        <div class="search-wrapper">
            <input 
                wire:model.live.debounce.300ms="search" 
                type="text" 
                class="search-input" 
                placeholder="Search categories..."
            >
        </div>

        <div class="category-header">
            @if($search)
                Search Results for "{{ $search }}"
            @else
                All Categories
            @endif
        </div>

        <div class="category-row">
            @forelse($categories as $category)
                <div class="category-card">
                    <div class="icon-wrapper">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-img">
                    </div>
                    <div class="category-name">{{ $category->name }}</div>
                </div>
            @empty
                <div class="no-results">
                    No categories found.
                </div>
            @endforelse

        </div>
    </div>
</div>