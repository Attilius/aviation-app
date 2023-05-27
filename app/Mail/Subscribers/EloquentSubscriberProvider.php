<?php

namespace App\Mail\Subscribers;

use App\Contracts\SubscriberProviderInterface;
use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EloquentSubscriberProvider implements SubscriberProviderInterface
{
    /**
     * The Eloquent user model.
     *
     * @var string
     */
    protected string $model;

    /**
     * The callback that may modify the user retrieval queries.
     *
     * @var (\Closure(\Illuminate\Database\Eloquent\Builder):mixed)|null
     */
    protected $queryCallback;

    /**
     * Create a new database subscriber provider.
     *
     * @param string $model
     * @return void
     */
    public function __construct(string $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param mixed $identifier
     * @return Model|null
     */
    public function retrieveById($identifier): Model|null
    {
        $model = $this->createModel();

        return $this->newModelQuery($model)
            ->where($model->getAuthIdentifierName(), $identifier)
            ->first();
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return Model|null
     */
    public function retrieveByCredentials(array $credentials): Model|null
    {
        $credentials = array_filter(
            $credentials,
            function ($key) {return $key == 'email';},
            ARRAY_FILTER_USE_KEY
        );
        if (empty($credentials)) {
            return null;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->newModelQuery();

        foreach ($credentials as $key => $value) {
            if (is_array($value) || $value instanceof Arrayable) {
                $query->whereIn($key, $value);
            } elseif ($value instanceof Closure) {
                $value($query);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }

    /**
     * Get a new query builder for the model instance.
     *
     * @param Model|null $model
     * @return Builder
     */
    protected function newModelQuery(Model $model = null): Builder
    {
        $query = is_null($model)
            ? $this->createModel()->newQuery()
            : $model->newQuery();

        with($query, $this->queryCallback);

        return $query;
    }

    /**
     * Create a new instance of the model.
     *
     * @return Model
     */
    public function createModel(): Model
    {
        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }
}
