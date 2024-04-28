<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Người dùng';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin đăng nhập')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Tên người dùng')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email'),

                        Forms\Components\TextInput::make('phone')
                            ->label('Số điện thoại')
                            ->required(),
                        Forms\Components\Select::make('role')
                            ->label('Vai trò')
                            ->options([
                                0 => 'Người dùng',
                                1 => 'Quản trị viên',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('password')
                            ->label('Mật khẩu')
                            ->required(
                                fn (User $user) => is_null($user->id)
                            ),
                    ]),
                Forms\Components\Section::make('Thông tin pháp lý')
                    ->relationship('userInfo')
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->label('Địa chỉ')
                            ->required(),
                        Forms\Components\TextInput::make('cccd')
                            ->label('CCCD')
                            ->required(),
                        Forms\Components\TextInput::make('fullname')
                            ->label('Họ và tên')
                            ->required(),
                        Forms\Components\TextInput::make('birthday')
                            ->label('Ngày sinh')
                            ->required(),
                        Forms\Components\FileUpload::make('image_front')
                            ->directory('images/cccd')
                            ->label('Ảnh mặt trước CCCD')
                            ->required()
                            ->previewable()
                            ->downloadable(true)
                            ->openable(true),
                        Forms\Components\FileUpload::make('image_back')
                            ->previewable()
                            ->downloadable(true)
                            ->openable(true)
                            ->directory('images/cccd')
                            ->label('Ảnh mặt sau CCCD')
                            ->required(),
                        Forms\Components\FileUpload::make('image_selfie')
                            ->previewable()
                            ->downloadable(true)
                            ->openable(true)
                            ->directory('images/cccd')
                            ->label('Ảnh chụp chân dung')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'pending' => 'Chờ duyệt',
                                'approved' => 'Đã duyệt',
                                'rejected' => 'Từ chối',
                            ])
                            ->required(),
                    ]),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Tên người dùng'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->label('Số điện thoại'),
                Tables\Columns\TextColumn::make('role')
                    ->label('Vai trò')
                    ->formatStateUsing(fn ($state) => $state === 1 ? 'Quản trị viên' : 'Người dùng'),
            ])
            ->filters([
                // filter role
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        0 => 'Người dùng',
                        1 => 'Quản trị viên',
                    ])
                    ->label('Vai trò'),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)->filtersFormColumns(2)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
