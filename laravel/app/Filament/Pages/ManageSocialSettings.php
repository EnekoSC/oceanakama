<?php

namespace App\Filament\Pages;

use App\Settings\SocialSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageSocialSettings extends SettingsPage
{
    protected static ?string $navigationIcon = null;

    protected static string $settings = SocialSettings::class;

    protected static ?string $title = 'Redes sociales';

    protected static ?string $navigationLabel = 'Redes sociales';

    protected static ?string $navigationGroup = 'Ajustes';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('linkedin_url')
                    ->label('LinkedIn')
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('youtube_url')
                    ->label('YouTube')
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('instagram_url')
                    ->label('Instagram')
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tiktok_url')
                    ->label('TikTok')
                    ->url()
                    ->maxLength(255),
            ]);
    }
}
