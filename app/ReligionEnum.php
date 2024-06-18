<?php

namespace App;


use Filament\Support\Contracts\HasLabel;

enum ReligionEnum: string implements HasLabel
{
    case ROMANCATHOLIC = 'Roman Catholic';
    case MUSLIM = 'Muslim';
    case PROTESTANT = 'Protestant';
    case IGLESIANICRISTO = 'Iglesia ni Cristo';
    case SEVENTHDAYADVENTIST = 'Seventh Day Adventist';
    case ALGIPAY = 'Aglipay';
    case IGLESIAFILIPINAINDEPENDIENTE = 'Iglesia Filipina Independiente';
    case BIBLEBAPTISTCHURCH = 'Bible Baptist Church';
    case UCCP = 'UCCP';
    case JEHOVASWITNESS = "Jehova's Witness";
    case CHURCHOFCHRIST = 'Church of Christ';
    case NONE = 'None';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ROMANCATHOLIC => 'Roman Catholic',
            self::MUSLIM => 'Muslim',
            self::PROTESTANT => 'Protestant',
            self::IGLESIANICRISTO => 'Iglesia ni Cristo',
            self::SEVENTHDAYADVENTIST => 'Seventh Day Adventist',
            self::ALGIPAY => 'Aglipay',
            self::IGLESIAFILIPINAINDEPENDIENTE => 'Iglesia Filipina Independiente',
            self::BIBLEBAPTISTCHURCH => 'Bible Baptist Church',
            self::UCCP => 'UCCP',
            self::JEHOVASWITNESS => "Jehova's Witness",
            self::CHURCHOFCHRIST => 'Church of Christ',
            self::NONE => 'None',
        };
    }
}
