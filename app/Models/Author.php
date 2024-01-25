<?php

namespace App\Models;

use Illuminate\Support\Collection;
use App\Http\Resources\PostResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
        // return $this->hasMany(Post::class)->whereNotNull('published_at');
    }

    /**
     * Paginate from a instance
     *
     * @param array|object|Collection   $items
     * @param int   $perPage
     * @param int   $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     * 
     * @source https://stackoverflow.com/questions/56768921/how-to-paginate-collection-without-keys-laravel
     */

    public static function paginate(Collection $items, int $perPage = 3, ?int $page = null, array $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)
            ->toArray()), $items->count(), $perPage, $page, $options);
    }

    /**
     * Get all posts from the user and merge it
     *
     * @param \Illuminate\Database\Eloquent\Collection $authors
     *
     * @return \Illuminate\Support\Collection
     */
    public static function withPostResource($authors)
    {
        return $authors->map(function ($author) {
            
            $posts = $author->posts->map(function ($post) {
                return new PostResource($post);
            });

            return collect($author)->merge(['posts' => $posts]);
        });
    }
}
