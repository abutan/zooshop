<?php

namespace store\entities\site;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use store\entities\shop\Category;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property int $status [smallint(6)]
 * @property int $created_at [int(11)]
 *
 * @property Slide[] $slides
 * @property SliderAssignments[] $sliderAssignments
 * @property Category[] $sliderCategories
 */
class Slider extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public static function create($name): self
    {
        $slider = new static();
        $slider->name = $name;
        $slider->status = self::STATUS_DRAFT;
        $slider->created_at = time();

        return $slider;
    }

    public function edit($name): void
    {
        $this->name = $name;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        if ($this->isDraft()){
            throw new \DomainException('Слайдер уже отключен.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function activate(): void
    {
        if ($this->isActive()){
            throw new \DomainException('Слайдер уже опубликован.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    ##########

    public function addSlide(UploadedFile $file): void
    {
        $slides = $this->slides;
        $slides[] = Slide::create($file);
        $this->updateSlides($slides);
    }

    public function removeSlide($id): void
    {
        $slides = $this->slides;
        foreach ($slides as $i => $slide){
            if ($slide->isEqualTo($id)){
                unset($slides[$i]);
                $this->updateSlides($slides);
                return;
            }
        }
        throw new \DomainException('Слайд не найден.');
    }

    public function removeSlides(): void
    {
        $this->updateSlides([]);
    }

    public function moveSlideUp($id): void
    {
        $slides = $this->slides;
        foreach ($slides as $i => $slide){
            if ($slide->isEqualTo($id)){
                if ($prev = $slides[$i - 1] ?? null){
                    $slides[$i - 1] = $slide;
                    $slides[$i] = $prev;
                    $this->updateSlides($slides);
                }
                return;
            }
        }
        throw new \DomainException('Слайд не найден');
    }

    public function moveSlideDown($id): void
    {
        $slides = $this->slides;
        foreach ($slides as $i => $slide){
            if ($slide->isEqualTo($id)){
                if ($next = $slides[$i + 1] ?? null){
                    $slides[$i + 1] = $slide;
                    $slides[$i] = $next;
                    $this->updateSlides($slides);
                }
                return;
            }
        }
        throw new \DomainException('Слайд не найден');
    }

    private function updateSlides(array $slides): void
    {
        foreach ($slides as $i => $slide){
            $slide->setSort($i);
        }
        $this->slides = $slides;
    }

    ##########

    public function assignCategory($id): void
    {
        $assignments = $this->sliderAssignments;
        foreach ($assignments as $assignment){
            if ($assignment->isForCategory($id)){
                return;
            }
        }
        $assignments[] = SliderAssignments::create($id);
        $this->sliderAssignments = $assignments;
    }

    public function revokeCategory($id): void
    {
        $assignments = $this->sliderAssignments;
        foreach ($assignments as $i => $assignment){
            if ($assignment->isForCategory($id)){
                unset($assignments[$i]);
                $this->sliderAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Не найдено.');
    }

    public function revokeCategories(): void
    {
        $this->sliderAssignments = [];
    }

    ##########

    public function getSlides(): ActiveQuery
    {
        return $this->hasMany(Slide::class, ['slider_id' => 'id'])->orderBy('sort');
    }

    public function getSliderAssignments(): ActiveQuery
    {
        return $this->hasMany(SliderAssignments::class, ['slider_id' => 'id']);
    }
    public function getSliderCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('sliderAssignments');
    }

    ##########

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'slides', 'sliderAssignments',
                ],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()){
            foreach ($this->slides as $slide) {
                $slide->delete();
            }
            return true;
        }
        return false;
    }

    ##########

    public static function tableName(): string
    {
        return '{{%site_sliders}}';
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название слайдера',
            'status' => 'Состояние',
            'created_at' => 'Создан',
        ];
    }
}