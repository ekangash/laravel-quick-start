<?php

namespace App\Support\Pagination;

use App\Support\Enums\PaginationTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Cursor;
use Illuminate\Pagination\CursorPaginationException;
use Illuminate\Pagination\CursorPaginator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use UnexpectedValueException;

class CursorPageBuilder extends AbstractPageBuilder
{
    public function build(): Page
    {
        $limit = $this->applyMaxLimit((int) $this->request->input('pagination.limit', $this->getDefaultLimit()));

        return $limit > 0
            ? $this->buildWithPositiveLimit($limit)
            : $this->buildWithNotPositiveLimit($limit);
    }

    protected function buildWithNotPositiveLimit(int $limit): Page
    {
        $collection = $limit < 0 && !$this->forbidToBypassPagination ? $this->query->get() : new Collection();

        return new Page($collection, [
            'cursor' => null,
            'limit' => $limit,
            'next_cursor' => null,
            'previous_cursor' => null,
            'type' => PaginationTypeEnum::CURSOR,
        ]);
    }

    protected function buildWithPositiveLimit(int $limit): Page
    {
        $cursorHash = $this->request->input('pagination.cursor', null);
        $cursorHash = $cursorHash === '' ? null : $cursorHash;

        $cursor = Cursor::fromEncoded($cursorHash);
        if ($cursorHash !== null && $cursor === null) {
            throw new BadRequestHttpException("Unable to decode pagination cursor");
        }

        try {
            /** @var CursorPaginator */
            $paginator = $this->query->cursorPaginate($limit, cursor: $cursor);
        } catch (CursorPaginationException $e) {
            throw new BadRequestHttpException($e->getMessage());
        } catch (UnexpectedValueException $e) {
            throw new BadRequestHttpException("Invalid pagination cursor: {$e->getMessage()}");
        }

        return new Page($paginator->items(), [
            'cursor' => $cursorHash,
            'limit' => $limit,
            'next_cursor' => $paginator->nextCursor()?->encode(),
            'previous_cursor' => $paginator->previousCursor()?->encode(),
            'type' => PaginationTypeEnum::CURSOR,
        ]);
    }
}
