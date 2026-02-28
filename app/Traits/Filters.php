<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filters
{
    public function scopeApply(Builder $query, Request $request): Builder
    {
        if ($request->has('name') && $request->get('name') != null) {
            $query->where('name', 'like', '%' . $request->get('name') . '%');
        }

        if ($request->has('email') && $request->get('email') != null) {
            $query->where('email', '=',  $request->get('email'));
        }

        if ($request->has('slug') && $request->get('slug') != null) {
            $query->where('slug', '=',  $request->get('slug'));
        }

        if ($request->has('active') && $request->get('active') != null) {
            $query->where('active', '=',  $request->get('active'));
        }

        if ($request->has('date_from') && $request->get('date_from') != null) {
            $query->whereDate('created_at', '>=',  $request->get('date_from'));
        }

        if ($request->has('date_to') && $request->get('date_to') != null) {
            $query->whereDate('created_at', '<=',  $request->get('date_to'));
        }

        return $query;
    }
}
