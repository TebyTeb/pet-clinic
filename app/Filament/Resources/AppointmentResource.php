<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Appointment;
use App\Enums\AppointmentStatus;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\DatePicker::make('date')
                        ->native(false)
                        ->required()
                        ->minDate(now()),
                    Forms\Components\TimePicker::make('start')
                        ->required()
                        // ->native(false)
                        ->seconds(false)
                        ->minutesStep(5),
                    Forms\Components\TimePicker::make('end')
                        ->required()
                        // ->native(false)
                        ->seconds(false)
                        ->minutesStep(5),
                    Forms\Components\Select::make('pet_id')
                        ->native(false)
                        ->relationship(name: 'pet', titleAttribute: 'name')
                        ->required()
                        ->searchable()
                        ->preload(),
                    Forms\Components\Textarea::make('description')
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options(AppointmentStatus::class)
                        ->native(false)
                        ->required()
                        ->visibleOn('edit')

                    // Forms\Components\Section::make('Change Status')
                    //     ->schema([
                    //         Forms\Components\Actions::make([
                    //             Forms\Components\Actions\Action::make('Confirm')
                    //                 ->color('success'),
                    //             Forms\Components\Actions\Action::make('Cancel')
                    //                 ->color('danger'),
                    //         ])
                    //     ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pet.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start')
                    ->label('From')
                    ->time('h:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end')
                    ->label('To')
                    ->time('h:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Confirm')
                    ->action(function (Appointment $record) {
                        $record->status = AppointmentStatus::Confirmed;
                        $record->save();
                    })
                    ->visible(fn (Appointment $record) => $record->status === AppointmentStatus::Created)
                    ->color('success')
                    ->icon('heroicon-o-check'),
                Tables\Actions\Action::make('Cancel')
                    ->action(function (Appointment $record) {
                        $record->status = AppointmentStatus::Canceled;
                        $record->save();
                    })
                    ->visible(fn (Appointment $record) => $record->status !== AppointmentStatus::Canceled)
                    ->color('danger')
                    ->icon('heroicon-o-x-mark'),

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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
