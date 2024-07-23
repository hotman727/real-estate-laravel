<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('phone'),
                Forms\Components\Select::make('interest')
                    ->options([
                        'buying' => 'Buying',
                        'selling' => 'Selling',
                        'renting' => 'Renting',
                        'other' => 'Other',
                    ]),
                Forms\Components\Textarea::make('message'),
                Forms\Components\Select::make('status')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'qualified' => 'Qualified',
                        'lost' => 'Lost',
                        'converted' => 'Converted',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('score')
                    ->disabled()
                    ->helperText('Score is automatically calculated'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('interest'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('score')->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-M-Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'qualified' => 'Qualified',
                        'lost' => 'Lost',
                        'converted' => 'Converted',
                    ]),
                Tables\Filters\SelectFilter::make('interest')
                    ->options([
                        'buying' => 'Buying',
                        'selling' => 'Selling',
                        'renting' => 'Renting',
                        'other' => 'Other',
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
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}