<?php

namespace App\Filament\Resources;

use App\Models\Pet;
use Filament\Forms;
use Filament\Tables;
use App\Enums\PetType;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PetResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PetResource\RelationManagers;
use Illuminate\Support\Facades\Storage;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\FileUpload::make('avatar')
                        ->image()
                        ->imageEditor(),
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\DatePicker::make('date_of_birth')
                        ->required()
                        ->native(false)
                        ->maxDate(now())
                        ->closeOnDateSelection(),
                    Forms\Components\Select::make('type')
                        ->native(false)
                        ->options(PetType::class),
                    Forms\Components\Select::make('owner_id')
                        ->relationship(name: 'owner', titleAttribute: 'name')
                        ->native(false)
                        ->searchable()
                        ->preload()
                        // ->createOptionForm(OwnerResource::getOwnerForm())
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date(),
                Tables\Columns\TextColumn::make('owner.name')
                    ->sortable()
                    ->searchable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(PetType::class)
                    ->multiple()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Pet $record) {
                        // Deleting the image
                        Storage::delete('public/'.$record->avatar);
                    }),
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
            'index' => Pages\ListPets::route('/'),
            'create' => Pages\CreatePet::route('/create'),
            'edit' => Pages\EditPet::route('/{record}/edit'),
        ];
    }
}
