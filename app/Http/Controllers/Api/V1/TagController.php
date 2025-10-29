<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Tag;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\Issue\IssueShortResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\Tag\TagRequest;

/**
 * Class TagController
 *
 * Контроллер для управления тегами
 */
class TagController extends Controller
{
    /**
     * Получить список тегов с пагинацией
     *
     * @return JsonResource Коллекция ресурсов тегов
     */
    public function index(): JsonResource
    {
        return TagResource::collection(Tag::paginate(config('pagination.per_page')));
    }

    /**
     * Получить информацию о конкретном теге
     *
     * @param Tag $tag Модель тега
     * @return TagResource Ресурс тега
     */
    public function show(Tag $tag): TagResource
    {
        return new TagResource($tag);
    }

    /**
     * Создать новый тег
     *
     * @param TagRequest $request
     * @return TagResource Ресурс созданного тега
     */
    public function store(TagRequest $request): TagResource
    {
        return new TagResource(Tag::create($request->getDto()->toArray()));
    }

    /**
     * Обновить информацию о теге
     *
     * @param Tag $tag Модель тега для обновления
     * @param TagRequest $request
     * @return TagResource Ресурс обновленного тега
     */
    public function update(Tag $tag, TagRequest $request): TagResource
    {
        $tag->fill($request->getDto()->toArray())->save();
        return new TagResource($tag);
    }

    /**
     * Удалить тег
     *
     * @param Tag $tag Модель тега для удаления
     * @return JsonResponse Ответ об успешном удалении
     */
    public function destroy(Tag $tag): JsonResponse
    {
        $tag->delete();

        return responseOk();
    }

    /**
     * Получить список задач, связанных с тегом, с пагинацией
     *
     * @param Tag $tag Модель тега
     * @return JsonResource Коллекция ресурсов задач
     */
    public function issues(Tag $tag): JsonResource
    {
        return IssueShortResource::collection($tag->issues()->paginate(config('pagination.per_page')));
    }
}
