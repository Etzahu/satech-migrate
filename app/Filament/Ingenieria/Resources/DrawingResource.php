<?php

namespace App\Filament\Ingenieria\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Drawing;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DrawingCategory;
use Filament\Resources\Resource;
use App\Models\SubDrawingCategory;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Ingenieria\Resources\DrawingResource\Pages;
use App\Filament\Ingenieria\Resources\DrawingResource\RelationManagers;

class DrawingResource extends Resource
{
    protected static ?string $model = Drawing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('drawing_category_id')
                    ->label('Categoría de planos')
                    ->relationship(name: 'drawingCategory', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('sub_drawing_category_id', null);
                        $set('folio', '');
                    })
                    ->required(),

                Forms\Components\Select::make('sub_drawing_category_id')
                    ->label('Sub categoría de planos')
                    ->options(fn(Get $get): Collection => SubDrawingCategory::query()
                        ->where('drawing_category_id', $get('drawing_category_id'))
                        ->pluck('name', 'id'))
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        if (filled($get('sub_drawing_category_id')) && filled($get('sub_drawing_category_id'))) {
                            $newNumber = '0001';
                            $category = DrawingCategory::query()->find($get('drawing_category_id'));
                            $subCaterory = SubDrawingCategory::query()->find($get('sub_drawing_category_id'));
                            $recordCount = Drawing::query()->where('sub_drawing_category_id', $get('sub_drawing_category_id'))->count();
                            if ($recordCount > 0) {
                                $newNumber = str_pad($recordCount + 1, 4, "0", STR_PAD_LEFT);
                            }
                            $set('folio', 'GPT-' . $category->code . '-' . $subCaterory->code . '-' . $newNumber);
                        } else {
                            $set('folio', '');
                        }
                    })
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),

                Forms\Components\Select::make('user_id')
                    ->label('Usuario responsable')
                    ->options(User::where('active', 1)->get()->pluck('name', 'id'))
                    ->default(auth()->user()->id)
                    ->required(),

                Forms\Components\TextInput::make('folio')
                    ->label('Folio')
                    ->readonly()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('drawingCategory.name')
                    ->label('Categoría de planos')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subDrawingCategory.name')
                    ->label('Sub categoría de planos')
                    ->sortable(),
                Tables\Columns\TextColumn::make('responsible.name')
                    ->label('Responsable')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDrawings::route('/'),
            'create' => Pages\CreateDrawing::route('/create'),
            'edit' => Pages\EditDrawing::route('/{record}/edit'),
        ];
    }
}
