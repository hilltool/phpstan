<?php declare(strict_types = 1);

namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Traits\MaybeCallableTypeTrait;
use PHPStan\Type\Traits\MaybeIterableTypeTrait;
use PHPStan\Type\Traits\MaybeObjectTypeTrait;

class MixedType implements CompoundType
{

	use MaybeCallableTypeTrait;
	use MaybeIterableTypeTrait;
	use MaybeObjectTypeTrait;

	/**
	 * @var bool
	 */
	private $isExplicitMixed;

	public function __construct(bool $isExplicitMixed = false)
	{
		$this->isExplicitMixed = $isExplicitMixed;
	}

	/**
	 * @return string[]
	 */
	public function getReferencedClasses(): array
	{
		return [];
	}

	public function accepts(Type $type): bool
	{
		return true;
	}

	public function isSuperTypeOf(Type $type): TrinaryLogic
	{
		return TrinaryLogic::createYes();
	}

	public function isSubTypeOf(Type $otherType): TrinaryLogic
	{
		if ($otherType instanceof self) {
			return TrinaryLogic::createYes();
		}

		return TrinaryLogic::createMaybe();
	}

	public function describe(): string
	{
		return 'mixed';
	}

	public function isOffsetAccesible(): TrinaryLogic
	{
		return TrinaryLogic::createMaybe();
	}

	public function getOffsetValueType(): Type
	{
		return new MixedType();
	}

	public function isExplicitMixed(): bool
	{
		return $this->isExplicitMixed;
	}

	public static function __set_state(array $properties): Type
	{
		return new self($properties['isExplicitMixed']);
	}

}
