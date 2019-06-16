Laravel RbacNot Builder
===

This is a builder project for [pitsolu/rbacnot](https://github.com/pitsolu/rbacnot).

The aim of `pitsolu/rbacnot` is to do something like this with role based access:

```php
/**
     * @Post("/add/user")
     * @Only("permission:add_user")
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addUser()
    {
    	//

        return response()->json([], 200);
    }
```

Packages used are [laravelcollective/annotations](https://github.com/LaravelCollective/annotations) and [zizaco/entrust](https://github.com/Zizaco/entrust).
