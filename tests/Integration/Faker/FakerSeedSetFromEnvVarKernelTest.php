<?php

declare(strict_types=1);

/*
 * This file is part of the zenstruck/foundry package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Foundry\Tests\Integration\Faker;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Configuration;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

/**
 * @author Nicolas PHILIPPE <nikophil@gmail.com>
 * @requires PHPUnit >=11.0
 */
#[RequiresPhpunit('>=11.0')]
final class FakerSeedSetFromEnvVarKernelTest extends KernelTestCase
{
    use Factories, FakerTestTrait, ResetDatabase;

    #[Test]
    public function faker_seed_can_be_set_by_environment_variable(): void
    {
        // let's fake, we're starting from a fresh kernel
        $this->tearDown();
        Configuration::shutdown();
        Configuration::resetFakerSeed();

        self::bootKernel(['environment' => 'faker_seed_env_var']);

        self::assertSame(1234, Configuration::fakerSeed());
    }

    #[Test]
    #[Depends('faker_seed_can_be_set_by_environment_variable')]
    public function faker_seed_is_already_set(): void
    {
        self::assertSame(1234, Configuration::fakerSeed());
    }
}
