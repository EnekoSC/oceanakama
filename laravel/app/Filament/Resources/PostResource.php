<?php

namespace App\Filament\Resources;

use App\Enums\EstadoPost;
use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Blog';

    protected static ?string $modelLabel = 'Post';

    protected static ?string $pluralModelLabel = 'Posts';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información básica')
                    ->schema([
                        Forms\Components\TextInput::make('titulo.es')
                            ->label('Título (ES)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('titulo.en')
                            ->label('Título (EN)')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('titulo.fr')
                            ->label('Título (FR)')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Textarea::make('extracto.es')
                            ->label('Extracto (ES)')
                            ->rows(3),
                        Forms\Components\Textarea::make('extracto.en')
                            ->label('Extracto (EN)')
                            ->rows(3),
                        Forms\Components\Textarea::make('extracto.fr')
                            ->label('Extracto (FR)')
                            ->rows(3),
                    ])->columns(2),

                Forms\Components\Section::make('Contenido')
                    ->schema([
                        Forms\Components\RichEditor::make('contenido.es')
                            ->label('Contenido (ES)')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('contenido.en')
                            ->label('Contenido (EN)')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('contenido.fr')
                            ->label('Contenido (FR)')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Imagen')
                    ->schema([
                        Forms\Components\FileUpload::make('imagen_url')
                            ->label('Imagen')
                            ->image()
                            ->directory('posts')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Publicación')
                    ->schema([
                        Forms\Components\Select::make('estado')
                            ->options(collect(EstadoPost::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                            ->required()
                            ->default(EstadoPost::Borrador->value),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Fecha de publicación'),
                        Forms\Components\Select::make('user_id')
                            ->label('Autor')
                            ->relationship('autor', 'name')
                            ->required()
                            ->default(fn () => auth()->id()),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagen_url')
                    ->label('Img')
                    ->circular(),
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->formatStateUsing(fn (EstadoPost $state) => $state->label())
                    ->color(fn (EstadoPost $state) => match ($state) {
                        EstadoPost::Borrador => 'gray',
                        EstadoPost::Publicado => 'success',
                        EstadoPost::Archivado => 'warning',
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('autor.name')
                    ->label('Autor'),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options(collect(EstadoPost::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
