
@extends('user.userLayout')

@section('resources')


@stop



@section('user-center-right')
    <form class="profile-detail" id="profileForm">
        <div class="profile-line-detail">
            <label>用户名:</label>
            <input type="text">
        </div>
        <div class="profile-line-detail">
            <label>邮箱:</label>
            <input type="text">
        </div>
        <div class="profile-line-detail">
            <label>生日:</label>
            <select>
                <option>1950 年</option>
                <option>1950 年</option>
                <option>1950 年</option>
                <option>1950 年</option>
                <option>1955 年</option>
                <option>1956 年</option>
                <option>1957 年</option>
                <option>1958 年</option>
                <option>1959 年</option>
            </select>

            <select>
                <option>1 月</option>
                <option>2 月</option>
                <option>3 月</option>
                <option>4 月</option>
                <option>5 月</option>
                <option>6 月</option>
                <option>7 月</option>
                <option>8 月</option>
                <option>9 月</option>
                <option>10 月</option>
                <option>11 月</option>
                <option>12 月</option>
            </select>

            <select>
                <option>1 日</option>
                <option>2 日</option>
                <option>3 日</option>
                <option>4 日</option>
                <option>5 日</option>
                <option>6 日</option>
                <option>7 日</option>
                <option>8 日</option>
                <option>9 日</option>
                <option>10 日</option>
                <option>11 日</option>
                <option>12 日</option>
            </select>
        </div>

        <div class="profile-line-detail">
            <label>自我介绍:</label>
            <textarea ></textarea>
        </div>

        <div style="width:686px; margin-top:20px;">
            <div class="regular-btn long-btn red-btn auto-margin">
                保存
            </div>
        </div>
    </form>
@stop


