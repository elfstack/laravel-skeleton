<?php


namespace App\Utils;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Listing Builder
 *
 * @author Stanley Cao <contact@stanleytsau.me>
 */
class Listing
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Builder
     */
    protected $query;

    /**
     * @var int
     */
    protected $perPage = 10;

    /**
     * @var int
     */
    protected $page;

    /**
     * @var array
     */
    protected $columns = ['*'];

    /**
     * @var array
     */
    protected $sortableColumns;

    /**
     * @var array
     */
    protected $filterableColumns;

    /**
     * @var array
     */
    protected $searchableColumns;
    /**
     * @var string
     */
    private $defaultOrder;
    /**
     * @var string
     */
    private $defaultColumn;

    private function __construct($model)
    {
        if (is_string($model)) {
            $model = new $model;
        }

        if (!is_a($model, Model::class)) {
            throw new \Exception('Listing is only compatible with eloquent');
        }

        $this->model = $model;
        $this->query = $model->newQuery();
        return $this;
    }

    /**
     * Create a new Listing instance
     *
     * @param $model
     * @return static
     * @throws \Exception
     */
    public static function create($model): self
    {
        return new Listing($model);
    }

    /**
     * Set columns to display
     *
     * @param array $columns
     * @return $this
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Add sorting functionality
     *
     * @param array $sortableColumns
     * @return $this
     */
    public function attachSorting(array $sortableColumns, string $defaultColumn='id', string $defaultOrder='asc')
    {
        $this->sortableColumns = $sortableColumns;
        $this->defaultColumn = $defaultColumn;
        $this->defaultOrder = $defaultOrder;
        return $this;
    }

    /**
     * Add filterable functionality
     *
     * @param array $filterableColumns
     * @return $this
     */
    public function attachFiltering(array $filterableColumns)
    {
        $this->filterableColumns = $filterableColumns;
        return $this;
    }

    /**
     * Add searchable functionality
     *
     * @param array $serchableColumns
     * @return $this
     */
    public function attachSearching(array $serchableColumns)
    {
        $this->searchableColumns = $serchableColumns;
        return $this;
    }

    /**
     * Run sorting
     *
     * @param string $column
     * @param string $direction
     */
    private function querySorting(string $column, string $direction): void
    {
        if (in_array($column, $this->sortableColumns) && in_array($direction, ['desc', 'asc'])) {
            $this->query->orderBy($column, $direction);
        }
    }

    /**
     * Run filtering
     *
     * @param string $column
     * @param $value
     */
    private function queryFiltering(string $column, $value): void
    {
        if (in_array($column, $this->filterableColumns)) {
            if (is_array($value)) {
                $this->query->whereIn($column, $value);
            } else {
                $this->query->where($column, $value);
            }
        }
    }

    /**
     * Run search
     *
     * @param string $value
     */
    private function querySearch(string $value): void
    {
        foreach ($this->searchableColumns as $column) {
            $this->searchLike($this->query, $column, $value);
        }
    }

    /**
     * Execute paginator
     *
     * @return LengthAwarePaginator
     */
    private function paginate()
    {
        return $this->query->paginate($this->perPage, $this->columns, 'page', $this->page);
    }

    /**
     * Get filters from query param
     *
     * @param string $filter
     * @return array
     */
    public function getFilter(string $filter): array
    {
        $values = explode(';', $filter);

        return array_map(function ($value) {
            $delimiterPos = strpos($value, ':');
            $column = substr($value, 0, $delimiterPos);
            $values = explode(',', substr($value, $delimiterPos + 1));
            return [
                'column' => $column,
                'values' => $values
            ];
        }, $values);
    }

    /**
     * Get result
     *
     * @param Request $request
     * @param Response $response
     *
     * @return LengthAwarePaginator
     */
    public function get(Request $request)
    {
        $this->processRequest($request);

        return $this->paginate();
    }

    /**
     * Process listing request
     * Ordering Query: orderBy=<column>&direction=<desc|asc>
     * Filtering Query: filter=<column1:val1,val2;column2:val1,val2;column3:val1,val2>
     * Pagination Query: perPage=<perPage>&page=<page>
     * Search Query: keyword=<keyword>
     *
     * @param Request $request
     */
    protected function processRequest(Request $request)
    {
        $params = $request->query();

        if ($this->sortableColumns && !empty($params['orderBy'])) {
            $this->querySorting($params['orderBy'], $params['direction']);
        } else {
            $this->query->orderBy($this->defaultColumn, $this->defaultOrder);
        }

        if ($this->filterableColumns && !empty($params['filter'])) {
            foreach ($this->getFilter($params['filter']) as $filter) {
                $this->queryFiltering($filter['column'], $filter['values']);
            }
        }

        if ($this->searchableColumns && !empty($params['keyword'])) {
            $this->querySearch($params['keyword']);
        }

        if (!empty($params['perPage'])) {
            $this->perPage = $params['perPage'];
        }

        if (!empty($params['page'])) {
            $this->page = $params['page'];
        }
    }

    /**
     * Modify built query in any way
     *
     * @param callable $modifyQuery
     * @return $this
     */
    public function modifyQuery(callable $modifyQuery): self
    {
        $modifyQuery($this->query);

        return $this;
    }

    /**
     * @param $query
     * @param $column
     * @param $token
     */
    private function searchLike($query, $column, $token): void
    {

        // MySQL and SQLite uses 'like' pattern matching operator that is case insensitive
        $likeOperator = 'like';

        // but PostgreSQL uses 'ilike' pattern matching operator for this same functionality
        if ($this->model->getConnection()->getDriverName() == 'pgsql') {
            $likeOperator = 'ilike';
        }

        $query->orWhere($column, $likeOperator, '%' . $token . '%');
    }
}

